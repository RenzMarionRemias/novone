	@extends('home.index')


		<div class="home-section">
			<div class="container">
				<div class="text-center home-content">
					<div class="company-name">
						<h1>Novone</h1>
					</div>
					<div class="company-desc">
						<p>Chemical Providers Corp.</p>
					</div>
					<div class="line-1">
						<hr>
					</div>
					<div class="get-started">
						<button type="button" class="btn btn-danger btn-lg" id="getStartedBtn">Get Started <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="services-section">
			<div class=" services-content">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
		</div>
		<div class="services-section">
			<div class="services-content">
				<div class="text-center services-title">
					<p>Our Services</p>
				</div>
				<div class="services-offered">
					<div class="row">
						<div class="col-md-4 first-service">
							<div class="first-service-content">
								<div class="text-center">
									<div class="service-icon">
										<i class="fa fa-cogs" id="manufactureIcon" aria-hidden="true"></i>
									</div>
									<div class="service-title">
										<p>We Manufacture</p>
									</div>
									<div class="service-desc">
										<p align="justify">We are the manufacturer of NCPC that has been building its reputation as a producer of quality products at highly conpetitive prices with the use of innovative technologies. </p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 second-service">
							<div class="second-service-content">
								<div class="text-center">
									<div class="service-icon">
										<i class="fa fa-truck" id="deliverIcon" aria-hidden="true"></i>
									</div>
									<div class="service-title">
										<p>We Deliver</p>
									</div>
									<div class="service-desc">
										<p align="justify">We are committed to deliver the highest quality products and provide services to our valued customers. <br><br></p>
									</div> 
								</div>
							</div>
						</div>
						<div class="col-md-4 third-service">
							<div class="third-service-content">
								<div class="text-center">
									<div class="service-icon">
										<i class="fa fa-phone-square" id="assistIcon" aria-hidden="true"></i>
									</div>
									<div class="service-title">
										<p>We Assist Customers</p>
									</div>
									<div class="service-desc">
										<p align="justify">For any questions or feedback, please contact us and we will try our best to respond to your inquiry. <br><br></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br />
		<div class="about-section">
			<div class="about-content">
				<div class="text-center about-title">
					<p>About Us</p>
				</div>
				<div class="about-novone">
					<div class="about-novone-content">
						<div class="text-center">
							<div class="novone-name">
								<p><span class="company-name">NOVONE</span> Chemical Providers Corp.</p>
							</div>
							<div class="line-2">
								<hr>
							</div>
							<div class="container">
								<div class="novone-background">
									<p align="justify">
										Novone Company originated in 2002 as a chemical importation
										firm that targeted other industries’ needs and sourced them from
										its network of reputable suppliers worldwide. Seeing the huge
										demand for household and consumer chemicals; Novone Chemical Provider Company was formed in 2009 as an importation, manufacturing, and marketing firm dedicated solely to addressing the needs of this division. Situated in Meycauayan City, Bulacan, Novone Chemical Provider Company has since been building its reputation as a producer of quality chemicals at highly competitive prices with its advantage being an importer of raw materials coupled with its use of innovative technologies in manufacturing to increase efficiency and effectivity of their
										products.
										</p>
									
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<br><br><br>
		<div class="contact-section">
			<div class="contact-content">
				<div class="text-center contact-title">
					<p>Contact Us</p>
				</div>
				<div class="contact-form">
					<div class="container">
						<div class="contact-form-content">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<!--<label class="contact-form-label" for="">Full Name:</label>-->
										<input type="text" placeholder="Enter Full Name" class="input-lg form-control contact-form-input" name="">
									</div>
									<div class="form-group">
										<!--<label class="contact-form-label" for="">Phone Number:</label>-->
										<input type="text" class="input-lg form-control contact-form-input" placeholder="Enter your number" name="">
									</div>
									<div class="form-group">
										<!--<label class="contact-form-label" for="">Email Address:</label>-->
										<input type="text" class="input-lg form-control contact-form-input" placeholder="Enter your Email Address" name="">
									</div>
									<div class="form-group">
										<!--<label class="contact-form-label" for="">Title:</label>-->
										<input type="text" class="input-lg form-control contact-form-input" placeholder="Enter Topics" name="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<!--<label class="contact-form-label" for="">Message:</label>-->
										<textarea placeholder="Enter your Inquiry" class="form-control contact-form-input" name="" id="messageTxtArea"></textarea>
									</div>
								</div>
							</div>
							<div class="text-center contact-button">
								<button type="button" class="btn btn-danger btn-lg">Send Message <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-section">
			<div class="first-footer">
				<div class="container">
					<div class="first-footer-content">
						<div class="row">
							<div class="text-center col-md-4">
								<p class="first-footer-title">Quick Inquiry :</p>
								<p class="quick-contact-content"><i class="fa fa-phone-square phone-icon" aria-hidden="true"></i>&nbsp;&nbsp;TEL.NO: +63-2-425-7356
								</p>
								<p class="quick-contact-content"><i class="fa fa-phone-square phone-icon" aria-hidden="true"></i>&nbsp;&nbsp;MOBILE.NO: +63-916-213-0538
								</p>
								<p class="quick-contact-content"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;novone.company@gmail.com</p>
								<p class="quick-contact-content"><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;&nbsp;8 Calle Fabrica St., Malhacan, Meycauayan, Bulacan, Philippines.</p>
							</div>
							<div class="text-center col-md-4">
								<p class="first-footer-title">Follow Us At :</p>
								<button type="button" class="btn btn-default btn-lg social-media-btn"><i class="fa fa-facebook-square" aria-hidden="true"></i></button>
							</div>
							<div class="text-center col-md-4 email-updates-section">
								<p class="first-footer-title">Email Updates :</p>
								<div class="form-group">
									<input type="text" class="input-md form-control email-input" name="" placeholder="Your Email Address Here..">
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-default btn-md submit-btn">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>