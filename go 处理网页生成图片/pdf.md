### 生成原理

> - 采用chromedp+golang的方式生成
> - golang提供一个接口，接口主要作用是根据传入的url生成一pdf流响应给请求端

### 安装方式

> 安装顺序至上而下
> - 先安装google-chrome的一些依赖 apt-get install libxss1 libappindicator1 libindicator7
> - 再执行 apt --fix-broken install
> - 安装google-chrome 该文件包已上传qyhzit-system-vendor目录git clone到本地，执行 dpkg -i google-chrome-stable_current_amd64.deb
> - 执行 apt-get install -f
> - 安装中文字体 apt-get install ttf-wqy*[文泉驿]或fonts-arphic-uming[文鼎-上海宋]
> - 安装golang生成pdf程序 该程序已上传至qyhzit-system-vendor目录git clone到本地即可，移动到项目目录下deploy/bin目录启动


----------------------------------------------------------
ubuntu 
apt-get install libxss1 libappindicator1 libindicator7
apt --fix-broken install
dpkg -i google-chrome-stable_current_amd64.deb
apt-get install -f
apt-get install ttf-wqy-zenhei ttf-wqy-microhei

---------------------------------------------

centos 第二三部 执行 sudo yum localinstall google-chrome-stable_current_x86_64.rpm

centos 中文字体
yum install wqy-zenhei-fonts
yum install wqy-microhei-fonts
-----------------------------------------------------
### 调用方式

> - curl http://127.0.0.1:8095/?url=base64decode(url)