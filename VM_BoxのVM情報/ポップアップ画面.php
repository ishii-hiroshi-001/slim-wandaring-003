

    <script>

        function conFirm_proc() { // 問い合わせるボタンをクリックした場合
            document.getElementById('poPup').style.display = 'block';
            return false;
        }

        function okFunc() { // OKをクリックした場合
            document.contactform.submit();
        }

        function noFunc() { // キャンセルをクリックした場合
            document.getElementById('poPup').style.display = 'none';
        }

    </script>



    <div >
        <form method="POST" name="contactform" action="test2.php">    名前<br />
            <input type="text" name="user_name" value="" />
            <br /><br />    問い合わせ内容<br />
            <textarea name="user_question"></textarea>
            <br /><br />
            <input type="submit" value="問い合わせる" name="contact" onclick="return conFirm_proc()" />

            <script type="text/javascript">
                self.focus();
            </script>

        </form>
    </div>

    <div id="poPup" style="width: 200px;display: none;padding: 30px 20px;border: 2px solid #000;margin: auto;">    問い合わせますか？<br />
            <button id="ok" onclick="okFunc()">OK</button>
            <button id="no" onclick="noFunc()">キャンセル</button>
    </div>



<script>

    document.getElementById('poPup').style.display = 'block'; // 画面表示

    document.getElementById('poPup').style.display = 'none';  // 画面消去

</script>



// test2.php
<?php
echo "問い合わせ内容";
echo "<br />";
echo "<br />";
echo "名前 :". $_POST['user_name'];
echo "<br />";
echo "問い合わせ内容 :".$_POST['user_question'];



/*

@echo off
 
rem メッセージ表示
echo WScript.Quit(MsgBox("よろしいですか？",vbOKCancel,"確認")) > %TEMP%\msgbox.vbs & %TEMP%\msgbox.vbs
echo %ERRORLEVEL%
 
rem ファイル削除
del /Q %TEMP%\msgbox.vbs
 
pause


WScript.Quit(MsgBox("納期チェンジャーを確認ください。" ,0 ,"確認"))


*/