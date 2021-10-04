@ECHO off

SET filename=新版・納期変更／2021年.xlsm
SET filefolde=\\NZB20101\ksc-work\変換器\★納期変更掲示板\2021年\
SET copyfile=%filefolde%%filename%
SET chekfile=F:\納期変更check\%filename%

:CHK_LOOP

TIMEOUT 60 /NOBREAK > NUL

COPY %copyfile% %chekfile% > NUL
FOR %%i IN (%chekfile%) DO SET fdate=%%~ti

REM ******************
SET nfdate=%fdate:/=%
SET fdate=%nfdate::=%
SET nfdate=%fdate: =%
REM ******************
REM ECHO %nfdate%

SET chekname=F:\納期変更check\TXT%nfdate%.TXT

IF EXIST %chekname% (GOTO FILE_TRUE) ELSE GOTO FILE_FALSE

:FILE_TRUE
REM echo "ファイルは変化ありません。"
DEL %chekfile% > NUL
GOTO CHK_LOOP

:FILE_FALSE

echo msgbox "「納期変更ファイル」が更新されました。" ^& vbCrLf ^& vbCrLf ^& "内容を確認し、印刷してから、業務に渡してください。",vbCritical,"納期変更の更新" > %TEMP%/msgboxtest.vbs & %TEMP%/msgboxtest.vbs

DEL F:\納期変更check\TXT*.TXT > NUL

COPY %copyfile% %chekfile% > NUL

FOR %%i IN (%chekfile%) DO SET fdate=%%~ti

REM ******************
SET nfdate=%fdate:/=%
SET fdate=%nfdate::=%
SET nfdate=%fdate: =%
REM ******************
REM ECHO %nfdate%

SET chekname=F:\納期変更check\TXT%nfdate%.TXT

MOVE %chekfile% %chekname% > NUL

GOTO CHK_LOOP


:BAT_END

