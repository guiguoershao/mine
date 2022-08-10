package helpers

import "time"

const (
	StartDate       = "2006-01-02 15:04:05"
	StartDateWithMs = "2006-01-02 15:04:05.000"
)

func GetDateByFormatWithMs(timeParams ...time.Time) string {
	timeVars := time.Now()
	if len(timeParams) > 0 {
		timeVars = timeParams[0]
	}
	return timeVars.Format(StartDateWithMs)
}
