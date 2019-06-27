import requests

url='https://www.baidu.com/'
respone=requests.get(url)#请求百度首页

print(respone.status_code)#打印请求结果的状态码
print(respone.content)#打印请求到的网页源码