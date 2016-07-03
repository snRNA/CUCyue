## Archieved 
1.将认证学号的界面重写为html页面，用户在注册页面输入学号后点击认证，传递参数stuid到认证的html界面（自动填充学号）。  

2.认证的html页面访问后台[check_new.php](http://www.13xinan.com/grade/check_new.php),传递stuid,获取cookie和验证码并且已“学号+verify.jpg”的命名规则暂时存入服务器中。认证的html页面将其在前端渲染显示。该php将stuid、token、从教务在线返回的cookie存在服务器的路径、认证码在服务器的路径存入到数据库的captcha表中，最后返回stuid 和其对应的token值（若之前出错返回定义好的若干错误值。）

3.用户点击验证码可以刷新再次调用check_new.php获取新的cookie和图片 

4.用户输入其学号对应的密码和认证码后，点击验证，html将stuid,password,capthca,token 以post的形式发送给后台的[login_test.php](http://www.13xinan.com/grade/login_test.php)。该php通过curl命令访问教务处来判断是否成功，若成功将获取该学号的相关身份信息（姓名、性别、专业等）存入到数据库cucyueinfo表中,将认证成功的学号和认证的时间存入authentication_str表中然后返回成功值0和token。  

## TODO  

1.界面需要继续修改美化。    
~~好像没有要todo的了hhh~~