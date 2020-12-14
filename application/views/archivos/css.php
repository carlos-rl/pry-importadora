<link rel="icon" type="image/jpg" href="<?= base_url() ?>static/imagen/importadora.png">
<!-- Vendor CSS-->
<link rel="stylesheet" href="<?= base_url() ?>static/font-awesome/css/font-awesome.css">
<!-- Favicons -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>static/admin/assets/admin-all-demo.css">
<!-- JS Core -->
<script type="text/javascript" src="<?= base_url() ?>static/admin/assets/js-core.js"></script>
<style>
#loading .svg-icon-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -50px 0 0 -50px;
}
#header-logo .logo-content-big, .logo-content-small {
    background: none;
    font-weight: 900;
    font-size: 20px;
    text-indent: 1em;
    padding-top: 6px;
    color:white;
}
</style>
<style>
    .gc-container .header-tools {
        padding: 5px 5px 10px 5px;
        border-left: 0px solid #DDD;
        border-right: 0px solid #DDD;
    }

    a, a:hover {
        text-decoration: none;
    }
    .gc-container .footer-tools {
        border: 1px solid rgba(158,173,195,.16);
    }
    .btn:hover {
        box-shadow: 0 0px 0px rgba(0,0,0,.23),0 0px 0px rgba(0,0,0,.19);
    }
    .t3 {
        margin-top: 10px;
    }
    .report-div {
        padding: 10px 15px 15px 15px;
        margin: 0px 4px;
        font-weight: bold;
    }
    .datepicker-input-clear {
        cursor: pointer;
        text-decoration: none;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    #header-logo .logo-content-big, .logo-content-small {
        font-size: 17px;
    }
    #sidebar-menu li .sidebar-submenu {
        
        height: 80vh;
    }
    </style>
<script type="text/javascript">
$(window).load(function() {
    setTimeout(function() {
        $('#loading').fadeOut(400, "linear");
    }, 300);
});
</script>