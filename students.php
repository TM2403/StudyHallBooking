<?php
    ini_set('display_errors', TRUE);
    require_once("databases/auth/auth.php");
    require_once("databases/students/studentData.php");
    require_once("php/components.php");
    $token = bin2hex(random_bytes(16));
    $_SESSION["token"] = $token;

    $msg = "";
    if(isset($_GET["status"])){
        switch($_GET["status"]){
            case "fail":
              $msg = '<p class=" text-danger">ファイルの読み込みに失敗しました。</p>';
            break;
            case "success":
              $msg = '<p class=" text-success">生徒情報は更新されました。</p>';
            break;
        }
    }
?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php echo getNavbar() ?>
<div class="container">
    <div class="row">
        <div class="main col-md-12 col-xs-12">
            <div class="card border-info">
                <div class="card-header">
                    <h2 class="card-title text-info">生徒情報の更新</h2>
                </div>
                <div class="card-body text-center">
                 <?php echo $msg;?>
                    <form method="POST" action="databases/students/addStudentsFromCSV.php" enctype="multipart/form-data">
                        <input type="file" name="studentData" accept=".csv" />
                        <input type="hidden" name="token" value="<?php echo $token; ?>"/>
                        <input type="submit" class="btn btn-success" value="送信"/>
                    </form>
                    <input type="button" onclick="window.location.href = 'index.php'" class="btn btn-secondary" style="width: 100px" value="戻る" />
                </div>

            </div>

        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
