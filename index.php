<html>

<head>
    <title>留言本</title>
    <style type="text/css">
        TD {
            font-size: 12px;
            line-height: 150%;
        }
    </style>
</head>

<body>
    <table border=1 cellspacing=0 cellspadding=0 style="border-collapse:collapse" align=center width=400 bordercolor=black height=382>
        <tr>
            <td height=100 bgcolor=#6c6c6c style="font-size:30px;line-height:30px">
                <font color=#ffffff face="黑體">歡迎來到留言本!</font>
            </td>
        </tr>
        <tr>
            <td height=25>
                <a href=send.php>[我要寫留言]</a>
            </td>
        </tr>
        <tr>
            <td height=200>
                <?php
                //連接資料庫
                $link = mysqli_connect("127.0.0.1", "root", "");
                mysqli_select_db($link, "mesboard");
                //選取資料庫所有留言渲染到頁面
                $query = "select * from message";
                //mysqli_query()：從某資料庫中讀取所有的（*）資料表
                $result = mysqli_query($link, $query);

                //若沒有留言，mysqli_num_rows = 計算筆數
                if (mysqli_num_rows($result) < 1) {
                    echo " 目前資料表中還沒有任何留言!";
                } else {
                    $totalnum = mysqli_num_rows($result); //獲取資料庫中所有資料筆數
                    $pagesize = 7; //每頁顯示7條
                    $page = "";
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                    }
                    if ($page == "") {
                        $page = 1;
                    }

                    //本頁開始記錄筆數 = (頁數-1) * 每頁紀錄筆數
                    $begin = ($page - 1) * $pagesize;
                    //ceil() = 無條件進位到整數位
                    $totalpage = ceil($totalnum / $pagesize); //所有筆數 除 每頁七筆 = 總頁數
                    //輸出分頁資訊
                    echo "<table border=0 width=95%><tr><td>";

                    $datanum = mysqli_num_rows($result);
                    echo "共有" . $totalnum . "條留言，每頁" . $pagesize . "條，共" . $totalpage . "頁。<br>";
                    //輸出頁碼
                    for ($i = 1; $i <= $totalpage; $i++) {
                        echo "<a href=index.php?page=" . $i . ">[" . $i . "] </a>";
                    }
                    echo "<br>";
                    //從message表中查詢當前頁面所要顯示的留言，並根據時間排序
                    $query = "select * from message order by addtime desc limit $begin,$pagesize";
                    $result = mysqli_query($link, $query);
                    $datanum = mysqli_num_rows($result);
                    //迴圈輸出所有留言，如果管理員已經回覆則同時輸出回覆
                    for ($i = 1; $i <= $datanum; $i++) {
                        $info = mysqli_fetch_array($result);
                        echo "->[" . $info['author'] . "]於" . $info['addtime'] . "說:<br>";
                        echo "  " . $info['content'] . "<br>";

                        echo "<hr>";
                    } //else結束
                    echo "</td></tr></table>";
                }
                mysqli_close($link)

                ?>
            </td>
        </tr>
    </table>

</body>

</html>