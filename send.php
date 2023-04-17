<html>

<head>
    <title>留言板</title>
</head>
<style type="text/css">
    TD {
        font-size: 12px;
        line-height: 150%;
    }
</style>

<body>
    <!-- border-collapse:collapse合併表格的邊框 -->
    <table border=1 cellspacing=0 cellspadding=0 style="border-collapse:collapse" align=center width=400 bordercolor=black>
        <tr>
            <td height=100 bgcolor=#6c6c6c>
                <font style="font-size:30px" color=#ffffff face="黑體">歡迎來到留言本!</font>
            </td>
        </tr>
        <tr>
            <td height=25>
                <a href=index.php>[返回留言板]</a>
            </td>
        </tr>
        <tr>
            <td height=200>
                <form method="POST" action="send.php">
                    <table border="1" width="95%" id="table1" cellspacing="0" cellpadding="0" bordercolor="#808080" style="border-collapse:collapse" height="265">
                        <tr>
                            <td colspan="2" height="29">
                                <p align="center">歡迎填寫你的留言</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="32%">
                                <p align="right">你的名字</p>
                            </td>
                            <td width="67%">
                                <input type="text" name="name" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td width="32%">
                                <p>留言內容</p>
                            </td>
                            <td width="67%">
                                <textarea rows="10" name="content" cols="31"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="99%" colspan="2">
                                <p align="center">
                                    <input type="submit" value="提交" name="B1">
                                </p>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>

    <?php

    date_default_timezone_set('Asia/Taipei'); //將時區設定為台北

    $name = "";
    $content = "";
    //isset()：檢查變數是否有設置
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    if (isset($_POST["content"])) {
        $content = $_POST["content"];
    }
    //先判斷使用者姓名是否為空
    if ($name != "") {
        $addtime = date("Y-m-d h:i:s"); //獲得當下日期
        $link = mysqli_connect("localhost", "root", ""); //PHP連線資料庫
        mysqli_select_db($link, "mesboard"); //選擇資料庫
        $insert = "insert into message(author,addtime,content,reply) values('$name','$addtime','$content','')";
        //mysqli_query($與資料庫的連接,"select * from 資料庫名稱")：從某資料庫中讀取所有的（*）資料表
        mysqli_query($link, $insert);
        //mysqli_close($與資料庫的連接)：斷開與資料庫的連線
        mysqli_close($link);

        // echo "<script language=javascript>alert('留言成功!單擊確定檢視留言.');location.href='index.php';</script>";

        if ($name !== "" & $content !== "") {
            echo "<script language=javascript>alert('留言成功!單擊確定檢視留言.');location.href='index.php';</script>";
        }
    }

    ?>

</body>

</html>