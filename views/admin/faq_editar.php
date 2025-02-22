<?php
if (isset($_COOKIE['msg'])) {
    setcookie('msg', '', time() - 3600, '/guia_brecho/');
    setcookie('tipo', '', time() - 3600, '/guia_brecho/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/guia_brecho/templates/cabecalho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/guia_brecho/models/faq.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['nivel_acesso'] === 1) {
    setcookie('msg', 'Você não tem permissão para acessar este conteúdo', time() + 3600, '/guia_brecho/');
    setcookie('tipo', 'perigo', time() + 3600, '/guia_brecho/');
    header('Location: /guia_brecho/index.php');
    exit();
}

try {
    $faq = new Faq($_GET['id']);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>

<?php if (isset($_COOKIE['msg'])) : ?>
    <?php if ($_COOKIE['tipo'] === 'sucesso') : ?>
        <div class="alert alert-success text-center m-3" role="alert">
            <?= $_COOKIE['msg'] ?>
        </div>
    <?php elseif ($_COOKIE['tipo'] === 'perigo') : ?>
        <div class="alert alert-danger text-center m-3" role="alert">
            <?= $_COOKIE['msg'] ?>
        </div>
    <?php else : ?>
        <div class="alert alert-info text-center m-3" role="alert">
            <?= $_COOKIE['msg'] ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<section class="d-flex align-items-center py-4">
    <div class="form-signin col-8 col-lg-4 m-auto">
        <form action="/guia_brecho/controllers/faq_edit_controller.php" method="POST">
            <h1 class="h3 mb-3 fw-normal">Editar FAQ</h1>

            <input type="hidden" class="form-control" id="floatingInput" name="id" value="<?= $faq->id_faq ?>">

            <div class="input-group my-3">
                <span class="input-group-text">Pergunta</span>
                <textarea class="form-control" aria-label="With textarea" name="faq_pergunta"><?= $faq->faq_pergunta ?></textarea>
            </div>

            <div class="input-group my-3">
                <span class="input-group-text">Resposta</span>
                <textarea class="form-control" aria-label="With textarea" name="faq_resposta"><?= $faq->faq_resposta ?></textarea>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Atualizar</button>
        </form>
    </div>

</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/guia_brecho/templates/rodape.php';
?>