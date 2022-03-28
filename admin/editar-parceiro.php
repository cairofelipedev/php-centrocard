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

if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
  $id = $_GET['edit_id'];
  $stmt_edit = $DB_con->prepare('SELECT * FROM partners WHERE id =:uid');
  $stmt_edit->execute(array(':uid' => $id));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);
} else {
  header("Location: painel-parceiros.php");
}

if (isset($_POST['btnsave'])) {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $district = $_POST['district'];
  $state = $_POST['state'];
  $tel = $_POST['tel'];
  $whats = $_POST['whats'];
  $email = $_POST['email'];
  $id_national = $_POST['id_national'];
  $site = $_POST['site'];
  $type_service = $_POST['type_service'];
  $type_attendance = $_POST['type_attendance'];
  $zip = $_POST['zip'];
  $how = $_POST['how'];
  $status = $_POST['status'];

  $imgFile = $_FILES['user_image']['name'];
  $tmp_dir = $_FILES['user_image']['tmp_name'];
  $imgSize = $_FILES['user_image']['size'];

  if ($imgFile) {
    $upload_dir = 'uploads/parceiros/'; // upload directory	
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    $name2 = preg_replace("/\s+/", "", $name);
    $name3 = substr($name2, 0, -1);
    $userpic = $name3 . "edit" . "." . $imgExt;
    if (in_array($imgExt, $valid_extensions)) {
      if ($imgSize < 5000000) {
        unlink($upload_dir . $edit_row['img']);
        move_uploaded_file($tmp_dir, $upload_dir . $userpic);
      } else {
        $errMSG = "Imagem grande demais, max 5MB";
      }
    } else {
      $errMSG = "Imagens apenas nos formatos JPG, JPEG, PNG & GIF files are allowed.";
    }
  } else {
    // if no image selected the old image remain as it is.
    $userpic = $edit_row['img']; // old image from database
  }

  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('UPDATE partners
    SET 
    name=:uname,
    address=:uaddress,
    city=:ucity,
    district=:udistrict,
    state=:ustate,
    tel=:utel,
    whats=:uwhats,
    email=:uemail,
    id_national=:uid_national,
    type_service=:utype_service,
    type_attendance=:utype_attendance,
    zip=:uzip,
    how=:uhow,
    status=:ustatus,
    img=:upic
    WHERE id=:uid');
    $stmt->bindParam(':uname', $name);
    $stmt->bindParam(':uaddress', $address);
    $stmt->bindParam(':ucity', $city);
    $stmt->bindParam(':udistrict', $district);
    $stmt->bindParam(':ustate', $state);
    $stmt->bindParam(':utel', $tel);
    $stmt->bindParam(':uwhats', $whats);
    $stmt->bindParam(':uemail', $email);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':uid_national', $id_national);
    $stmt->bindParam(':utype_service', $type_service);
    $stmt->bindParam(':utype_attendance', $type_attendance);
    $stmt->bindParam(':uzip', $zip);
    $stmt->bindParam(':uhow', $how);
    $stmt->bindParam(':ustatus', $status);
    $stmt->bindParam(':uid', $id);

    if ($stmt->execute()) {
      echo ("<script>window.location = 'painel-parceiros.php';</script>");
    } else {
      $errMSG = "Erro..";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Adicionar Parceiro / Painel Administrativo</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/icon-semfundo.png" rel="icon">
  <link href="../assets/img/icon-semfundo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.2/css/fileinput.min.css" integrity="sha512-optaW0zX5RBCFqhNsmzGuHHsD/tdnCcWl8B0OToMY01JVeEcphylF9gCCxpi4BQh0LY47BkJLyNC1J7M5MJMQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

  <?php include "components/header.php" ?>
  <?php include "components/sidebar.php" ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Adicionar Parceiro</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="painel-controle.php">Home</a></li>
          <li class="breadcrumb-item"><a href="painel-parceiros.php">Painel Parceiros</a></li>
          <li class="breadcrumb-item active">Adicionar Parceiros</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12 justify-content-center">

          <div class="card">
            <div class="card-body">
              <?php
              if (isset($errMSG)) {
              ?>
                <div class="alert alert-danger">
                  <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
                </div>
              <?php
              }
              ?>
              <!-- Vertical Form -->
              <form method="POST" enctype="multipart/form-data" class="row">
                <div class="col-md-6">
                  <h5 class="card-title">Informações</h5>
                  <div class="row">
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" value="<?php echo $name; ?>" name="name" placeholder="Nome Fantasia/Nome Completo" class="form-control" id="inputName">
                        <label for="">Nome Fantasia/Nome Completo</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" value="<?php echo $id_national; ?>" name="id_national" placeholder="CPNJ ou CNPJ do prestador" class="form-control" id="inputCnpjCPF">
                        <label for="">CNPJ/CPF</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <select name="type_service" class="form-select" id="floatingSelect" aria-label="Tipo">
                          <option value="<?php echo $type_service; ?>">
                            <?php
                            if ($type_service == 1) {
                              echo "CLÍNICA/POLICLÍNICA";
                            }
                            if ($type_service == 2) {
                              echo "CONSULTÓRIO MÉDICO/ODONTOLÓGICO";
                            }
                            if ($type_service == 3) {
                              echo "LABORATÓRIO DE ANÁLISES CLÍNICAS";
                            }
                            if ($type_service == 4) {
                              echo "DIAGNÓSTICOS POR IMAGEM";
                            } ?>
                            (selecionado)
                          </option>
                          <option value="1">CLÍNICA/POLICLÍNICA</option>
                          <option value="2">CONSULTÓRIO MÉDICO/ODONTOLÓGICO</option>
                          <option value="3">LABORATÓRIO DE ANÁLISES CLÍNICAS</option>
                          <option value="4">DIAGNÓSTICOS POR IMAGEM</option>
                        </select>
                        <label for="floatingSelect">Tipo de prestador de Serviço</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <select name="type_attendance" class="form-select" id="floatingSelect" aria-label="Tipo">
                          <option value="<?php echo $type_attendance; ?>">
                            <?php
                            if ($type_attendance == 1) {
                              echo "PRESENCIAL";
                            }
                            if ($type_attendance == 2) {
                              echo "ONLINE";
                            }
                            if ($type_attendance == 3) {
                              echo "DOMICILIAR";
                            }
                            if ($type_attendance == 4) {
                              echo "PRESENCIAL E ONLINE";
                            }
                            if ($type_attendance == 5) {
                              echo "PRESENCIAL E DOMICILIAR";
                            }
                            if ($type_attendance == 6) {
                              echo "ONLINE E DOMICILIAR";
                            }
                            if ($type_attendance == 7) {
                              echo "TODOS";
                            } ?>
                            (selecionado)
                          </option>
                          <option value="1">PRESENCIAL</option>
                          <option value="2">ONLINE</option>
                          <option value="3">DOMICILIAR</option>
                          <option value="4">PRESENCIAL E ONLINE</option>
                          <option value="5">PRESENCIAL E DOMICILIAR</option>
                          <option value="6">ONLINE E DOMICILIAR</option>
                          <option value="7">TODOS</option>
                        </select>
                        <label for="floatingSelect">Tipos de Atendimentos</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $email; ?>" name="email" placeholder="Email">
                        <label for="">Email</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $whats; ?>" name="whats" placeholder="Número do WhatsApp">
                        <label for="">WhatsApp</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $tel; ?>" name="tel" placeholder="Número de telefone">
                        <label for="">Telefone</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating mb-3">
                        <select name="status" class="form-select" id="floatingSelect" aria-label="Status">
                          <option value="<?php echo $status; ?>">
                            <?php
                            if ($status == 1) {
                              echo "Ativado";
                            }
                            if ($status == 2) {
                              echo "Desativado";
                            } ?> (selecionado)
                          </option>
                          <option value="1">Ativado</option>
                          <option value="2">Desativado</option>
                        </select>
                        <label for="floatingSelect">Status</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <h5 class="card-title">Localização</h5>
                  <div class="row">
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $address; ?>" name="address" placeholder="Endereço">
                        <label for="">Endereço</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $district; ?>" name="district" placeholder="Email">
                        <label for="">Bairro</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $city; ?>" name="city" placeholder="Cidade">
                        <label for="">Cidade</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $state; ?>" name="state" placeholder="Estado">
                        <label for="">Estado</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $zip; ?>" name="zip" placeholder="CEP">
                        <label for="">CEP</label>
                      </div>
                    </div>
                  </div>
                  <h5 class="card-title">Imagens</h5>
                  <div class="row">
                    <div class="col-md-4">
                      <img src="./uploads/parceiros/<?php echo $img; ?>" onerror="this.src='./assets/img/semperfil.png'" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                      <div class="file-loading">
                        <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center pt-2">
                  <button type="submit" name="btnsave" class="btn btn-primary">Adicionar</button>
                  <button type="reset" class="btn btn-secondary">Resetar</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
        </div>
    </section>

  </main><!-- End #main -->

  <?php include "components/footer.php"; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.2/js/fileinput.min.js" integrity="sha512-OgkQrY08KbdmZRLKrsBkVCv105YJz+HdwKACjXqwL+r3mVZBwl20vsQqpWPdRnfoxJZePgaahK9G62SrY9hR7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>