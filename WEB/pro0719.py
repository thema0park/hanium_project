import requests
from selenium import webdriver
import time
import pymysql
import os

# DB로 전송
db = pymysql.connect(host='119.67.32.123', port = 3306, user='VSS', passwd='password', db='db', charset='utf8')
cur = db.cursor()
sql = 'INSERT INTO `Device_info`(`Device_number`, `Check_data`, `Check_Reason`, `Total_Usingtime`, `Total_distance`) VALUES(%s, %s, %s, %s, %s)'
readSql = "select * from `Device_info`"
cur.execute(readSql)
rows = cur.fetchall()
result = str(rows)

def readData(result):
    cur.execute(readSql)
    row = cur.fetchall()
    updateResult = str(row)

    if result != updateResult:
        driver.find_element_by_name('readData').send_keys(updateResult)
        result = updateResult

def delivery(message):
    m = message.split(' ')
    cur.execute(sql, (m[0], m[1], m[2], m[3], m[4]))
    db.commit()


def readFile():
    f = open("C:\\Users\\wjdgh\\Downloads\\device.txt", 'r')
    line = f.readline()
    delivery(line)
    f.close()

    os.remove('C:\\Users\\wjdgh\\Downloads\\device.txt')

# 크롤링 코드
r = requests.get('http://119.67.32.123:8840/hanium/hanium.php')
gpsData = r.text

r_deviceInfo = requests.get('http://119.67.32.123:8840/hanium_deviceinfo.php')
deviceData = r_deviceInfo.text

r_CTgps = requests.get('http://119.67.32.123:8840/hanium/hanium_CTgps_data.php')
CTgpsData = r_CTgps.text

r_containerInfoEnv = requests.get('http://119.67.32.123:8840/hanium/hanium_CT_info_env.php')
containerEnvData = r_containerInfoEnv.text

# selenium 코드
driver = webdriver.Chrome('chromedriver')
driver.implicitly_wait(3)
driver.get('file:///C:/Users/wjdgh/pyqt_study/HTMLPage2.html')
driver.find_element_by_name('gpsData').send_keys(gpsData)
driver.find_element_by_name('deviceData').send_keys(deviceData)
driver.find_element_by_name('CT_gpsData').send_keys(CTgpsData)
driver.find_element_by_name('ctEnvData').send_keys(containerEnvData)
driver.find_element_by_id('marker').click()


while True:
    time.sleep(5)
    readData(result)
    if os.path.isfile("C:\\Users\\wjdgh\\Downloads\\device.txt"):
        readFile()

    r = requests.get('http://119.67.32.123:8840/hanium/hanium.php')
    r_deviceInfo = requests.get('http://119.67.32.123:8840/hanium/hanium_deviceinfo.php')
    r_CTgps = requests.get('http://119.67.32.123:8840/hanium/hanium_CTgps_data.php')
    r_containerInfoEnv = requests.get('http://119.67.32.123:8840/hanium/hanium_CT_info_env.php')

    if r.text != gpsData:
        gpsData = r.text

        driver.find_element_by_id('cleaner').click()
        driver.find_element_by_name('gpsData').clear()
        driver.find_element_by_name('gpsData').send_keys(gpsData)
        driver.find_element_by_id('marker').click()

    if r_deviceInfo.text != deviceData:
        deviceData = r_deviceInfo.text
        driver.find_element_by_name('deviceData').clear()
        driver.find_element_by_name('deviceData').send_keys(deviceData)

    if r_CTgps.text != CTgpsData:
        CTgpsData = r_CTgps.text

        driver.find_element_by_id('cleaner').click()
        driver.find_element_by_name('CT_gpsData').clear()
        driver.find_element_by_name('CT_gpsData').send_keys(CTgpsData)
        driver.find_element_by_id('marker').click()

    if r_containerInfoEnv.text != containerEnvData:
        containerEnvData = r_containerInfoEnv.text
        driver.find_element_by_name('ctEnvData').clear()
        driver.find_element_by_name('ctEnvData').send_keys(containerEnvData)
