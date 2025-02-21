<?php $page_title = "About Us"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>About Us</title>
    <style>
        .colorlib-about {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        .colorlib-about .video {
            position: relative;
            background-size: cover;
            background-position: center;
            height: 350px;
            border-radius: 10px;
            overflow: hidden;
        }

        .colorlib-about .video .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .colorlib-about .video a {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            color: #fff;
            text-decoration: none;
        }

        .colorlib-about .about-wrap {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .colorlib-about .about-wrap h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .colorlib-about .about-wrap p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .gototop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .gototop a {
            display: block;
            width: 50px;
            height: 50px;
            background: #007bff;
            color: #fff;
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .gototop a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="colorlib-about">
        <div class="container">
            <div class="row row-pb-lg">
                <div class="col-sm-6 mb-3">
                    <div class="video colorlib-video" style="background-image: url(images/about1.jpg);">
                        <a href="https://www.youtube.com/watch?v=mGQ-iamE1pI" class="popup-vimeo"><i class="icon-play3"></i></a>
                        <div class="overlay"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="about-wrap">
                        <h2>BIRKENSTOCK leading eCommerce Store around the Globe</h2>
                        <p>We champion continual progress for athletes and sport by taking action to help athletes reach their potential. Every job at BIRKENSTOCK is grounded in a team-first mindset, cultivating a culture of innovation and a shared purpose to leave an enduring impact.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
    </div>
</body>
</html>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>