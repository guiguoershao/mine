* 我们可以使用 update-alternatives 来为整个系统更改Python 版本。以 root 身份登录，首先罗列出所有可用的python 替代版本信息：


```
update-alternatives --list python
```

* update-alternatives: error: no alternatives for python 如果出现以上所示的错误信息，则表示 Python 的替代版本尚未被update-alternatives 命令识别。想解决这个问题，我们需要更新一下替代列表，将python2.7 和 python3.4 放入其中。
```
# update-alternatives --install /usr/bin/python python /usr/bin/python2.7 1
update-alternatives: using /usr/bin/python2.7 to provide /usr/bin/python (python) in auto mode
# update-alternatives --install /usr/bin/python python /usr/bin/python3.5 2
 update-alternatives: using /usr/bin/python3.4 to provide /usr/bin/python (python) in auto mode
```

* （这里我设置没有成功，但是我还是把电脑里的三个Python版本全都设置了一遍，最后还是成功切换Python版本了）

* --install 选项使用了多个参数用于创建符号链接。最后一个参数指定了此选项的优先级，如果我们没有手动来设置替代选项，那么具有最高优先 级的选项就会被选中。这个例子中，我们为/usr/bin/python3.4 设置的优先级为2，所以update-alternatives 命 令会自动将它设置为默认 Python 版本。


```
update-alternatives --config python
```
