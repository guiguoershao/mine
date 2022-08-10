package console

import (
	"fmt"
	"gin-mine/helpers"
	"io"
	"log"
	"os"
	"strings"
)

var DefaultWriter io.Writer = os.Stdout

func Print(format string, values ...interface{}) {

	if !strings.HasSuffix(format, "\n") {
		format += "\n"
	}

	fmtStr := fmt.Sprintf("[GIN][%s] ", helpers.GetDateByFormatWithMs())

	_, _ = fmt.Fprintf(DefaultWriter, fmtStr+format, values...)
}

func Fatal(format string, values ...interface{}) {

	if !strings.HasSuffix(format, "\n") {
		format += "\n"
	}

	fmtStr := fmt.Sprintf("[GIN][%s] ", helpers.GetDateByFormatWithMs())

	fmtStr = fmt.Sprintf(fmtStr+format, values...)

	log.Fatal(fmtStr)
}
