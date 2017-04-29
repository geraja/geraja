<nav class="navbar main-nav">
  <div class="row">
    <div class="col-md-2 col-brand">
      <a class="logo-brand" href="<?= base_url(); ?>">GeraJá</a>
    </div>
    <div class="col-md-10">
      <ul>
        <?php if($this->session->userdata('user')): ?>
          <?php if($this->session->userdata('is_admin')): ?>
            <li><a href="<?= base_url('gerenciador/admin'); ?>">Admin</a></li>
          <?php endif; ?>
          <li><a href="<?= base_url('gerenciador'); ?>">Meus Jogos</a></li>
          <li><a href="<?= base_url('gerenciador/minha-conta'); ?>">Minha conta</a></li>
        <?php else: ?>
          <li><a href="<?= base_url('criar-conta'); ?>">Criar conta</a></li>
          <li><a href="<?= base_url('login'); ?>">Login</a></li>
        <?php endif; ?>
        <li><a href="<?= base_url('jogos'); ?>">Jogos</a></li>
        <li><a href="<?= base_url('sobre'); ?>">Sobre</a></li>
        <li><a href="<?= base_url('contato'); ?>">Contato</a></li>
      </ul>
      <?php if($this->session->userdata('user')): ?>
        <a href="<?= base_url('sair'); ?>" class="logout">Sair</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
