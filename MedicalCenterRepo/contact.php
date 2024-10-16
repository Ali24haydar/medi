

<?php
    session_start();
    include('includes/header.php');
    include('functions/selectData.php');

?>
    <section id="contact-section" class="contact-section">
        <div id="contact-banner" class="contact banner">
            <div class="content banner">
                <h2><?php echo $nav['CONTACT US']; ?></h2>
                <ul class="breadcrumb">
                    <li><a href= "home.php"><?php echo $nav['HOME']; ?></a></li>
                    <li> | </li>
                    <li><?php echo $nav['CONTACT US']; ?></li>
                </ul>
            </div>
        </div>
        
        <div id="contact-container" class="contact container" >
            <div class="column-left">
                <!-- <form id="form2" class="contact-form" name="cForm" action="https://formsubmit.co/hijazizeinab5@gmail.com" method="POST"> -->
                <form id="form2" class="contact-form" name="cForm" method="POST">
                    <h2><?php echo $contact['formTitle']; ?></h2>
                    <h3><?php echo $nav['CONTACT US']; ?></h3>
                    <div class="input-control">
                        <div class="full-width">
                            <div class="half-width">
                                <input type="text" id="fname" name="fname" placeholder="<?php echo $contact['firstname']; ?>">
                                <div id="fname-error" class="error"></div>
                            </div>
                            <div class="half-width">
                                <input type="text" id="lname" name="lname" placeholder="<?php echo $contact['lastname']; ?>">
                                <div id="lname-error" class="error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="input-control">
                        <input type="text" id="email" name="email" placeholder="<?php echo $contact['email']; ?>" class="fw">
                        <div id="email-error" class="error"></div>
                    </div>
                    <div class="input-control">
                        <input type="text" id="subject" name="subject" placeholder="<?php echo $contact['subject']; ?>" class="fw">
                        <div id="subject-error" class="error"></div>
                    </div>
                    <div class="input-control">
                        <textarea cols="50" rows="5" id="message" name="message" placeholder="<?php echo $contact['message']; ?>"></textarea>
                        <div id="message-error" class="error"></div>
                    </div>
                    <!-- <input type="hidden" name="_template" value="box"></input>
                    <input type="hidden" name="_next" value="https://yourdomain.co/thanks.html">-->
                    <input type="button" id="btnSend"  class="contact-btn" name="btn-send" value="<?php echo $contact['send']; ?>">
                </form>
            </div>
            <div class="column-right">
                <div class="get-in-touch">
                    <h3><?php echo $footer['contactTitle']; ?></h3>
                    <span><i class="fa-solid fa-location-dot"></i><a href="https://www.google.com/maps/place/Beyrouth/@33.8892114,35.4630826,13z/data=!3m1!4b1!4m6!3m5!1s0x151f17215880a78f:0x729182bae99836b4!8m2!3d33.8937913!4d35.5017767!16zL20vMDlianY?entry=ttu" target="_blank"><?php echo $footer['address']; ?></a></span></br>
                    <span><i class="fa-solid fa-phone"></i><a href="tel:0096178960304"><?php echo $footer['phone']; ?></a></span></br>
                    <span><i class="fa-regular fa-envelope"></i><a href="mailto:hijazizeinab5@gmail.com"><?php echo $footer['email']; ?></a></span></br>
                </div>
            </div>
        </div>    
    </section>

    <section class="contact-map">
        <div class="map-container">
            <iframe class= "map" src="https://www.google.com/maps/embed?pb=!3m1!4b1!4m6!3m5!1s0x151f17215880a78f:0x729182bae99836b4!8m2!3d33.8937913!4d35.5017767!16zL20vMDlianY" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

   
    <?php
        include('includes/footer.php');
    ?>