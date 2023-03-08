import mysql.connector
import os
import operator
import pandas as pd
import sys
import natsort
import datetime
import json

source_path = sys.argv[1]
subfolder_path = sys.argv[2]
videolist_host = sys.argv[3]
status = sys.argv[4]

if subfolder_path == "3min":
    table_name = "three_min_video_lists"

if subfolder_path == "5min":
    table_name = "five_min_video_lists"

base_url = videolist_host+subfolder_path+"/"

FOLDER_PATH = source_path+subfolder_path+"/"

file_count = 0

mydb = mysql.connector.connect(
    host="localhost",
    port=3306,
    user="root",
    password="",
    database="cctv_powerball"
)

cursor = mydb.cursor()

def listDir(dir):
    global result
    global file_id
    global file_url
    global file_type
    global file_count

    fileNames = os.listdir(dir)
    sortedFileName = natsort.natsorted(fileNames, reverse=False)
    for fileName in sortedFileName:
        file = fileName.split("-")
        if 12 == len(file):
            file_id = file[0]
            temp_type = file[-1]
            file.pop(0)
            file.pop(-1)
            result = ' '.join(file).replace(".mp4", "")
            file_url = base_url + fileName
            file_path = FOLDER_PATH + fileName

            type = temp_type.split(".")
            file_type = type.pop(0)
            created_at = datetime.datetime.now()
            #get last id of the video_list table
            sql = "SELECT id FROM %s ORDER BY id ASC" % table_name
            cursor.execute(sql)
            exists_id = cursor.fetchall()

            try:
                li = operator.itemgetter(-1)(exists_id)
                last_index = int(''.join(map(str, li)))

                if int(file_id) > last_index:
                    saveData(file_id, file_url, file_type, file_count, result, status, created_at, file_path)
                else:
                    print("Already exists in database")

            except:
                saveData(file_id, file_url, file_type, file_count, result, status, created_at, file_path)
        else:
            print("file is not suitable this operation")

def saveData(file_id, file_url, file_type, file_count, result, status,created_at, file_path):
    result_array = result.split()
    sql = "INSERT INTO "+table_name+ " (id, url, type, count, result, status , created_at, file_path, normalball, powerball) VALUES (%s, %s, %s, %s, %s, %s, %s, %s,%s,%s)"
    val = (file_id, file_url, file_type, file_count, result, status, created_at, file_path, result_array[5], result_array[8])

    cursor.execute(sql, val)
    mydb.commit()
    print(cursor.rowcount, "record inserted.")

if __name__ == '__main__':
    listDir(FOLDER_PATH)
