  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="painel-controle.php">
          <i class="bi bi-grid"></i>
          <span>Painel Administrativo</span>
        </a>
      </li>
      <?php
      if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 2) or ($_SESSION['type'] == 3)) {
      ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-leads.php">
            <i class="fas fa-align-justify"></i>
            <span>Leads</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-planos.php">
            <i class="bi bi-bag-plus-fill"></i>
            <span>Planos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-beneficios.php">
            <i class="bi bi-heart-pulse-fill"></i>
            <span>Benefícios</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-material.php">
            <i class="bi bi-book-fill"></i>
            <span>Material</span>
          </a>
        </li>
      <?php } ?>
      <?php
      if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 6)) {
      ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-servicos.php">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Serviços</span>
          </a>
        </li>
      <?php } ?>
      <?php
      if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 6)) {
      ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-banners.php">
            <i class="fas fa-images"></i>
            <span>Banners</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-usuarios.php">
            <i class="fas fa-user"></i>
            <span>Usuários</span>
          </a>
        </li>
      <?php } ?>
      <?php
      if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 6)) {
      ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-parceiros.php">
            <i class="fas fa-hands-helping"></i>
            <span>Parceiros</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="painel-consultas.php">
            <i class="fa-solid fa-file-waveform"></i>
            <span>Consultas</span>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link collapsed" href="painel-medicos.php">
            <i class="fa-solid fa-user-doctor"></i>
            <span>Médicos</span>
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="categorias.php">
            <i class="fa-solid fa-notes-medical"></i>
            <span>Categorias</span>
          </a>
        </li>
      <?php } ?>
      <?php
      if ($_SESSION['type'] == 4) {
      ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="https://klinics.videoconsultas.app/paciente/autogestion">
            <i class="bi bi-camera-video-fill"></i>
            <span>Telemdicina</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="carteira-digital.php">
            <i class="bi bi-credit-card-2-front-fill"></i>
            <span>Carteira Digital</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="contratos.php">
            <i class="bi bi-file-earmark-text-fill"></i>
            <span>Contrato</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="manuais.php">
            <i class="bi bi-book-fill"></i>
            <span>Manual</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="contatos.php">
            <i class="bi bi-telephone-fill"></i>
            <span>Contatos</span>
          </a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="fas fa-sign-out-alt"></i>
          <span>Sair</span>
        </a>
      </li>
    </ul>
  </aside><!-- End Sidebar-->