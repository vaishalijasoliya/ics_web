<section class="section-bg" style="background:#F5F8FD;padding:20px;s">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
           <h1 style="color: #434067;">ICS</h1>
           <p style="padding-right:140px;">
            Please contact us to assist with any user assistance, issues, troubleshooting or to suggest new features for our products. Our technical support team will respond within 24 hours. </p>
           <div class="contact-box">
             <h4  style="color: #434067;">CONTACT US</h4>
            <p> <strong>Website: </strong></p>
            <p><strong>Email: </strong>clis@live.com.au</p>
           </div>
          </div>
          <div class="col-lg-6">
            <div class="form">
              <h4  style="color:#434067;"> <b>Send us a message</b></h4>
              <form action="<?php echo base_url('User/contact_mail'); ?>" method="post" role="form" class="contactForm" id="mailform">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                </div>
                <div class="text-center"><button type="submit" title="Send Message" style="background:#1bb1dc;color:white;border: 0;border-radius: 3px; padding: 8px 30px;color: #fff;transition: 0.3s;">Send Message</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
