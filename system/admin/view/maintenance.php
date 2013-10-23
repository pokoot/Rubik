<?php print html_doctype(); ?>
<?php print html_namespace(); ?>
<?php debug_start(); ?>
<head>
    <?php

        print html_title( "Log In" );

        // FAVICON

        $link = array(
            "rel"   => "shortcut icon" ,
            "href"  => "favicon.ico" ,
            "type"  => "image/x-icon"
        );

        print html_link( $link , true );


        $meta = array(
            array( "name" => "robots",          "content" => "no-cache" ),
            array( "name" => "description",     "content" => "" ),
            array( "name" => "keywords",        "content" => "" ),
            array( "name" => "Content-type",    "content" => "text/html; charset=utf-8" , "type" => "equiv" )
        );


        print html_meta( $meta );

        print html_css( "css.php?f=style" );
        print html_css( "css.php?f=login" );
        print html_css( "css.php?f=common" );

    ?>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" align="center">
    <tr>
        <td height="14%"></td>
    </tr>
    <tr>
        <td valign="top" align="center" height="">

            <div class="login" style="width:370px;" >

                <?php
                    $attributes = array(
                        "src"       => "logo.png"
                    );
                    print html_img( $attributes );
                ?>

                <div><?php print APPLICATION_NAME . " - " .  ENVIRONMENT; ?></div>

                <?php

                    $attributes = array(
                        "name"  => "main_form" ,
                        "id"    => "main_form"
                    );
                    print form_open( $attributes );

                ?>

                    <p class="tl" style="margin:15px 0px;">
                        <b>We Will be Back Soon</b>
                        <br/>
                        <br/>
                        We are busy upgrading Central Framework with technology and features.We apologize for the inconvinience and appreciate your patience. Thank you.

                        <br/><br/>
                        Don't forget to clear your browser cache after maintenance.

                       <br/><br/>
                        The Cellcity Team

                    </p>
                <?php print form_close(); ?>


            </div>

        </td>
    </tr>
    <tr>
        <td height="10%"></td>
    </tr>

</table>

<?php debug_end(); ?>

</body>

</html>
