package configs

type app struct {
	Mode  string
	Debug bool
	//Lang  string
	Addr string
}

type log struct {
	Level      string
	Path       string
	MaxSize    int `mapstructure:"max_size"`
	MaxAge     int `mapstructure:"max_age"`
	MaxBackups int `mapstructure:"max_backups"`
	Compress   bool
}

type mysql struct {
	User     string
	Password string
	DSN      string
}

type redis struct {
	Addr     string
	Password string
	Db       int
}
