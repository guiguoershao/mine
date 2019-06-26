<?php
$num=1;
$str="EasySwoole,Easy学swoole\n";
$pid = pcntl_fork();//新开一个子进程,上面的变量内存将会复制一份到子进程中.这个函数,在主进程中返回子进程进程id,在子进程返回0,开启失败在主进程返回-1
echo $str;//这下面的代码,将会被主进程,子进程共同执行

if($pid>0){//主进程代码
    echo "我是主进程,子进程的pid是{$pid}\n";
}elseif($pid==0){
    echo "我是子进程,我的pid是".getmypid()."\n";
}else{
    echo "我是主进程,我现在慌得一批,开启子进程失败了\n";
}