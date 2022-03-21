<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'dbconfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location: login.php");
endif;
error_reporting(~E_ALL);

if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM plans WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: painel-plans.php");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Serviços / Painel Administrativo</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/icon-semfundo.png" rel="icon">
  <link href="../assets/img/icon-semfundo.png" rel="apple-touch-icon">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <?php include "components/header.php" ?>
  <?php include "components/sidebar.php" ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Serviços</h1>
      <div class="d-flex justify-content-between">
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Serviços</li>
          </ol>
        </nav>
        <a href="add-servico.php">
          <button type="submit" name="btnsave" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Adicionar Serviços</button>
        </a>
      </div>
    </div><!-- End Page Title -->

    <section class="section card-body">
      <div class="row bg-white">
        <?php
        $stmt = $DB_con->prepare("SELECT * FROM services where type='EXAME' ORDER BY id DESC");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
        ?>
            <?php
            $stmt = $DB_con->prepare("SELECT * FROM partners");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
            ?>
                <?php echo $address; ?>
            <?php
              }
            }
            ?>
            <?php echo $private; ?>
            <?php echo $centrocard; ?>
          <?php
          }
        } else {
          ?>
          <div class="pt-4 col-xs-12">
            <div class="alert alert-danger">
              Sem Lead Cadastrado ...
            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <section id="clients" class="clients">
        <?php
        $stmt = $DB_con->prepare('SELECT id, name,img FROM partners ORDER BY id ASC');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
        ?>
            <a href="#parceiro-<?php echo $name; ?>" id="popup" class="jsModalTrigger">
              <center> <button class="btn-saiba-mais btn" type="button" id="popup" class="jsModalTrigger">
                  Saiba Mais
                </button>
              </center>
            </a>
            <div class="collapse" id="collapseExample<?php echo $id; ?>">
              <div class="card card-body">
                <?php echo $name; ?>
              </div>
            </div>
        <?php
          }
        }
        ?>
        </div>
        </div>
        </div>
        <?php
        $stmt = $DB_con->prepare('SELECT * FROM partners ORDER BY id ASC');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
        ?>
            <div id="parceiro-<?php echo $name; ?>" class="modal2">
              <div class="modal__overlay jsOverlay"></div>
              <div class="modal__container">
                <div class="parceiro-box d-flex">
                  <div class="parceiro-infos">
                    <h4 class="text-center">Contato</h4>
                    <div class="row justify-content-center">
                      <div class="col-md-4">
                        <p class="text-center lead"><?php echo $tel; ?></p>
                      </div>
                      <?php if ($email != '') { ?>
                        <div class="col-md-8">
                          <p class="text-center lead parceiro-email"><?php echo $email; ?></p>
                        </div>
                      <?php } ?>
                    </div>
                    <h4>Especialidades</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <p class="lead">&nbsp;&bull; <?php echo $esp_1; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="modal__close jsModalClose">&#10005;</button>
              </div>
            </div>
        <?php
          }
        } ?>
      </section><!-- End Clients Section -->
    </section>

  </main><!-- End #main -->

  <?php include "components/footer.php"; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/script.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>