package main

import (
	"database/sql"
	"fmt"

	_ "github.com/go-sql-driver/mysql"
)

var db *sql.DB

func initDB() (err error) {
	dsn := "fengyan:k@wDNEoPGVPa0B7f@tcp(120.77.156.30:23306)/go_db?charset=utf8mb4&parseTime=True"

	db, err = sql.Open("mysql", dsn)

	if err != nil {
		return err
	}

	err = db.Ping()
	if err != nil {
		return err
	}

	fmt.Printf("db: %v\n", db)
	return nil
}

type UserInfo struct {
	id       int
	username string
	password string
}

// 查询一条用户数据
func queryOneRow() {
	sqlStr := "select * from user_tbl where id=?"
	var u UserInfo
	// 确保QueryRow之后调用Scan方法，否则持有的数据库链接不会被释放
	err := db.QueryRow(sqlStr, 2).Scan(&u.id, &u.username, &u.password)
	if err != nil {
		fmt.Printf("scan failed, err:%v\n", err)
		return
	}
	fmt.Printf("id:%d name:%s age:%s\n", u.id, u.username, u.password)
}

func queryMultiRow() {
	sqlStr := "select * from user_tbl"
	rows, err := db.Query(sqlStr)

	if err != nil {
		fmt.Printf("query failed, err: %v\n", err)
		return
	}

	// 非常重要： 关闭rows释放持有的数据库链接
	defer rows.Close()

	// 循环读取结果集的数据
	for rows.Next() {
		var u UserInfo
		err := rows.Scan(&u.id, &u.username, &u.password)

		if err != nil {
			fmt.Printf("scan failed, err: %v\n", err)
			return
		}
		fmt.Printf("id: %d username:%s password:%s\n", u.id, u.username, u.password)
	}
}

func insertData() {
	sqlStr := "insert into user_tbl(username,password) values (?,?)"
	ret, err := db.Exec(sqlStr, "张三", "ldfjaskl")
	if err != nil {
		fmt.Printf("insert failed, err: %v\n", err)
		return
	}
	theID, err := ret.LastInsertId()

	if err != nil {
		fmt.Printf("get lastinsert ID failed, err:%v\n", err)
		return
	}
	fmt.Printf("insert success, the id is %d.\n", theID)
}

func delData() {
	sql := "delete from user_tbl where id = ?"
	ret, err := db.Exec(sql, 1)

	if err != nil {
		fmt.Printf("删除失败, err:%v\n", err)
		return
	}
	rows, err := ret.RowsAffected()
	if err != nil {
		fmt.Printf("删除行失败, err:%v\n", err)
		return
	}
	fmt.Printf("删除成功，删除的行数：%d. \n", rows)
}

func updateData() {
	sql := "update user_tbl set username=?, password=? where id=?"
	ret, err := db.Exec(sql, "Kite2", "kite123", 6)
	if err != nil {
		fmt.Printf("更新失败, err:%v\n", err)
		return
	}
	rows, err := ret.RowsAffected()
	if err != nil {
		fmt.Printf("更新行失败, err:%v\n", err)
		return
	}
	fmt.Printf("更新成功, 更新的行数: %d. \n", rows)
}

func main() {
	err := initDB()
	if err != nil {
		fmt.Printf("初始化失败, error: %v\n", err)
		return
	} else {
		fmt.Printf("初始化成功\n")
	}

	// queryOneRow()
	// insertData()
	// delData()
	// queryMultiRow()
	updateData()
}
