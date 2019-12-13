<html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>匹配玩家</title>
    <link href="/worker-chat/css/bootstrap.min.css" rel="stylesheet">
    <link href="/worker-chat/css/jquery-sinaEmotion-2.1.0.min.css" rel="stylesheet">
    <link href="/worker-chat/css/style.css" rel="stylesheet">
	
    <script type="text/javascript" src="/worker-chat/js/swfobject.js"></script>
    <script type="text/javascript" src="/worker-chat/js/web_socket.js"></script>
    <script type="text/javascript" src="/worker-chat/js/jquery.min.js"></script>
    <script type="text/javascript" src="/worker-chat/js/jquery-sinaEmotion-2.1.0.min.js"></script>
    <script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
    });
    </script>
    <script type="text/javascript">
    if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
    // 如果浏览器不支持websocket，会使用这个flash自动模拟websocket协议，此过程对开发者透明
    WEB_SOCKET_SWF_LOCATION = "/worker-chat/swf/WebSocketMain.swf";
    // 开启flash的websocket debug
    WEB_SOCKET_DEBUG = true;
    var ws, client_id, myVar;

    // 连接服务端
    function connect() {
       // 创建websocket
        ws = new WebSocket("ws://47.104.70.213:7272");
        // ws = new WebSocket("ws://192.168.56.11:7272");
       // 当socket连接打开时，输入用户名
       // ws.onopen = onopen;
       // 当有消息时根据消息类型显示不同信息
       ws.onmessage = onmessage; 
       ws.onclose = function() {
    	  console.log("连接关闭，定时重连");
          connect();
       };
       ws.onerror = function() {
     	  console.log("出现错误");
       };
    }

    // 服务端发来消息时
    function onmessage(e)
    {
        console.log(e.data);
        var data = JSON.parse(e.data);
        switch(data['type']){
            // 服务端ping客户端
            case 'ping':
                // 回应服务端心跳
                ws.send('{"type":"pong"}');
                break;
            case 'init':
                console.log('当前client_id:'+data['client_id']);
                client_id = data['client_id'];
            break;
            case 'rank':
                console.log(data['content']);
                // 关闭定时器
                clearInterval(myVar);
                alert('匹配成功,开始答题');
            break;
            case 'logout':

            break;
        }
    }

    // 开始匹配
    function onSubmit() {
        // 获取客户端ID
        var to_client_id = client_id;
        // 自定义用户ID
        var to_user_id = $('#uid').val();
        // 发起匹配请求
        $.ajax({
            url: '/rank/'+to_user_id+'/match',
            method: 'POST',
            dataType: 'json',
            data: {
                'client_id':to_client_id,
            }
        }).done(function (a) {
            console.log(a.data)
            // 开启定时器,每秒监测一次匹配池
            myVar=setInterval(function(){checkMatch()},1000);
        }); 
    }
    // 执行匹配监测
    function checkMatch() {
        $.ajax({
        url: '/rank/checkMatch',
        method: 'POST',
        dataType: 'json',
        data: {}
        }).done(function (a) {
            console.log(a) 
        });
    }
  </script>
</head>
<body onload="connect();">
    <div class="container">
	    <div class="row clearfix">
	        <div class="col-md-6 column">
	           <form onsubmit="onSubmit(); return false;">
                    <div class="say-btn">
                        <input type="text" id="uid" placeholder="输入uid" class="btn btn-default"  />
                        <input type="submit" class="btn btn-default" value="开始匹配" />
                    </div>
               </form>
	        </div>
	    </div>
    </div>
    <script type="text/javascript">var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F7b1919221e89d2aa5711e4deb935debd' type='text/javascript'%3E%3C/script%3E"));</script>
    <script type="text/javascript">
      // 动态自适应屏幕
      document.write('<meta name="viewport" content="width=device-width,initial-scale=1">');
    </script>
</body>
</html>
