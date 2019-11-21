<div class="c-auth__form">
    <section class="ctn-form">
        <h1 class="c-title">パスワード変更</h1>
        <?php
            if(!empty($error)):
        ?>
            <ul class="area-error-msg">
        <?php 
            foreach ($error as $key => $val):
        ?>
            <li class="c-error--msg"><?=$val?></li>
        <?php
            endforeach;
        ?>
                </ul>
        <?php
            endif;
        ?>

        <div class="authform p-editpass__form">
            <?=$editpassform?>
        </div>
        
    </section>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
