from urllib import request
from bs4 import BeautifulSoup

url = "http://pic.netbian.com/4kmeinv"
headers = {
    "user-agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36"
}

page = request.Request(url, headers=headers)

# 打开url, 获取HtmlResponse返回对象并
pageInfo = request.urlopen(page).read()

# 将获取到的内容转换成BeautifulSoup格式,并将html.parser作为解析器
soup = BeautifulSoup(pageInfo, 'html.parser')

# 查找所有a标签中 class='title' 的语句
# titles = soup.find_all('ul', 'list')
# print(titles)
imgs = soup.find_all('ul', 'clearfix')

print(soup.find_all('a'))

# with open('./test.txt', 'w') as file:

