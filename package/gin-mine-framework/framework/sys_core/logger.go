package sys_core

import (
	"gin-mine/configs"
	"go.uber.org/zap"
	"go.uber.org/zap/zapcore"
	"os"
)
import "github.com/natefinch/lumberjack"

func Logger() *zap.Logger {
	config := configs.GetInstance().Entity
	hook := lumberjack.Logger{
		Filename:   config.Log.Path,       // 日志文件路径
		MaxSize:    config.Log.MaxSize,    // 每个日志文件保存的大小 单位:M
		MaxAge:     config.Log.MaxAge,     // 文件最多保存多少天
		MaxBackups: config.Log.MaxBackups, // 日志文件最多保存多少个备份
		Compress:   config.Log.Compress,   // 是否压缩
	}
	encoderConfig := zapcore.EncoderConfig{
		MessageKey:     "msg",
		LevelKey:       "level",
		TimeKey:        "time",
		NameKey:        "logger",
		CallerKey:      "caller",
		StacktraceKey:  "stacktrace",
		LineEnding:     zapcore.DefaultLineEnding,
		EncodeLevel:    zapcore.LowercaseLevelEncoder,
		EncodeTime:     zapcore.ISO8601TimeEncoder,
		EncodeDuration: zapcore.SecondsDurationEncoder,
		EncodeCaller:   zapcore.ShortCallerEncoder, // 短路径编码器
		EncodeName:     zapcore.FullNameEncoder,
	}

	var writes = []zapcore.WriteSyncer{zapcore.AddSync(&hook)}

	// 如果是开发环境，同时在控制台上也输出
	if config.App.Debug {
		writes = append(writes, zapcore.AddSync(os.Stdout))
	}

	// 设置日志级别
	level, err := zapcore.ParseLevel(config.Log.Level)
	if err != nil {
		level = zap.DebugLevel
	}

	// 设置日志级别
	atomicLevel := zap.NewAtomicLevel()
	atomicLevel.SetLevel(level)

	core := zapcore.NewCore(
		zapcore.NewJSONEncoder(encoderConfig),
		zapcore.NewMultiWriteSyncer(writes...),
		atomicLevel,
	)

	// 开启开发模式，堆栈跟踪
	caller := zap.AddCaller()

	// 开启文件及行号
	development := zap.Development()

	// 构造日志
	return zap.New(core, caller, development)
}
