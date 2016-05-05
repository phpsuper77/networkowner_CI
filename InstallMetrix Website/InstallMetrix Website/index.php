<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US">
<!--<![endif]-->
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width">
    <title>InstallMetrix</title>
   
    <link rel='stylesheet' href='style.css' type='text/css' media='all' />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <link rel='stylesheet' href='css/ie.css?ver=20121010' type='text/css' media='all' />
    <![endif]-->
    <script type='text/javascript' src='js/jquery-1.10.2.js'></script>
    <script type='text/javascript' src='js/parallax.js'></script>
    </head>
    <body>                        
    	<!-- BEGIN LRAGE VIEW -->
        
        
        <!-- END LRAGE VIEW -->
        
        <!-- BEGIN EMAIL FORM -->
       
        <div class="background" id="sign-up">
            <div class="cross"></div>
            <div id="animation-form">
                


                <div class="box-wrap" id="box-sign-up">
                <div id="signup-div">
                    <h1>Sign Up</h1>
                        <form action="login.php" class="signup-form" id="subForm" method="post">
                        <input type="hidden" name="tryout" value="1">
                        <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>   

                            <label for="fieldName">First Name: *</label>
                            <input class="input" id="fieldName" name="first_name" placeholder="First Name" value="" onFocus="if (this.value == 'First Name') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'First Name';}" required type="text">

                            </td>
                                            <td>   

                            <label for="fieldLast">Last Name: *</label>
                            <input class="input" id="fieldLast" name="last_name" placeholder="Last Name" value="Last Name" onFocus="if (this.value == 'Last Name') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Last Name';}" required type="text"><br>
                             </td>
                             </tr>
                             <tr>
                                            <td>  
                           <label for="fieldCompany">Company: *</label><br>
                            <input class="input" id="fieldCompany" name="company" placeholder="Company" value="Company" onFocus="if (this.value == 'Company') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Company';}" required type="text">
       
                             </td>
                                            <td>  
                            <label for="fieldWebsite">Website: *</label><br>
                            <input class="input" id="fieldWebsite" name="company_website" placeholder="Company Website" value="Company Website" onFocus="if (this.value == 'Company Website') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Company Website';}" required type="text"><br>
                             </td>
                                                          </tr>
                             <tr>

                                            <td>  
                            <label for="fieldEmail">Email: *</label>
                            <input class="input email" id="fieldEmail" name="email" placeholder="Enter your email" value="Enter your email" onFocus="if (this.value == 'Enter your email') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Enter your email';}" required type="email">
                             </td>
                                            <td>  
                            <label for="fieldPhone">Phone: *</label><br>
                            <input class="input" id="fieldPhone" name="phone" placeholder="Phone" value="Phone" onFocus="if (this.value == 'Phone') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Phone';}" required type="text"><br>
                             </td>
                                                          </tr>
                             <tr>
                                            <td>  
                            <label for="password">Password: *</label>
                            <input class="input" type="password" id="password" name="pass" placeholder="Password" value="" onFocus="if (this.value == '***') {this.value = '';}" onBlur="if (this.value == '') {this.value = '***';}" required type="text">
                             </td>
                                            <td>  
                            <label for="fieldConfirm">Confirm Password: *</label><br>
                            <input class="input" type="password" id="fieldConfirm" name="confirm" placeholder="Confirm" value="" onFocus="if (this.value == '***') {this.value = '';}" onBlur="if (this.value == '') {this.value = '***';}" required type="text"><br>
                             </td>
                                                          </tr>
                                                          
                            <tr>
                                            <td>  
                            <label for="aim">AIM: </label>
                            <input class="input" id="aim" name="aim" placeholder="Aim" value="Aim" onFocus="if (this.value == 'Aim') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Aim';}" required type="text">
                             </td>
                                            <td>  
                            <label for="skype">Skype: </label><br>
                            <input class="input" id="skype" name="skype" placeholder="Skype" value="Skype" onFocus="if (this.value == 'Skype') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Skype';}" required type="text"><br>
                             </td>
                                                          </tr>
                             
                                           
                                        
                                    </tbody>
                                </table>
                                <!-- END .responsive-table -->  

                                
                            <p class="custom-check">
                            <input type="checkbox" id="c1" name="cc"/>
                            <label for="c1"><span></span>I agree with the <a target="_blank" href="http://installmetrix.com/terms.html"><u>terms & conditions</u></a></label>
                            
                            </p>

                             <p class="custom-check">  
                             <input type="hidden" id="user_type" name="user_type" value="100">
                            <input type="checkbox" id="c2" onclick="SelectPublisher();"/>
                            <label for="c2">Publisher<span></span></label>
                            <input type="checkbox" id="c3" onclick="SelectAdvertiser();"/>
                            <label for="c3"><span></span>Advertiser</label>
                            
                            </p>
                            <input type="submit" id="SendButton" name="submit" class="button button-transparent" value="Create account" />
                                
                            </div>
                            <!-- END .panel-container -->
                        </form>
                </div>
                    <!-- END .box .form-state -->
                    
                    <div class="box success-state" style="margin-top: 140px;">
                        <div id="tick-text">
                            <img id="tick" src="images/tick.png" alt="Success" /> 
                            <div id="tick-text2">Thank you for signing up with us. Your application is being reviewed and will hear back from us within 48 hours.</div>
                            <div class="clear-float"></div>
                        </div>
                        <!-- END #tick-text -->
                        
                       
                
                    </div>
                    <!-- END .box .success-state -->
            
                </div>
                <!-- END .box-wrap -->
                
        
                
            </div>
            <!-- END #animation-form -->
            
        </div>
        <!-- END #background -->

        
        <!-- END EMAIL FORM -->

        
        <div class="background" id="sign-in">
            <div class="cross"></div>
            <div id="animation-form2">
               


                <div class="box-wrap" id="box-login">
                    
                    <h1>Login</h1>
                       <form action="login.php" class="signin-form" id="subForm2" method="post">
                        <input type="hidden" name="tryout" value="1">
                        <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                       
                             <tr>

                                            <td>  
                            <label for="user_email">Email:</label>
                             </td>
                                           
                                                          </tr>
                             <tr>
                                            <td>  
                            <!--<input class="input" id="user_email" name="user_email" placeholder="Enter your email" value="Enter your email" onFocus="if (this.value == 'Enter your email') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Enter your email';}" required type="email">-->
                            <input class="input" id="user_email" name="user_email" placeholder="Enter your email" value="Enter your email" onFocus="if (this.value == 'Enter your email') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Enter your email';}" >
                             </td>
                                           
                                                          </tr>
                             <tr>
                                            <td>  
                            <label for="user_pass">Password:</label>
                             </td>
                                           
                                                          </tr>
                             <tr>
                                            <td>  
                            <input class="input" id="user_pass" type="password" name="user_pass" placeholder="Password" value="Password" onFocus="if (this.value == 'Password') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Password';}" required type="text">
                             </td>
                                           
                                                          </tr>
                                
                                <tr><td><a id="forget_btn" href="#">Forgot your password?</a></td></tr>
                                           
                                        
                                    </tbody>
                                </table>
                                <!-- END .responsive-table -->  

                               

                            
                           
                            <p class="submit-row"><input type="submit" id="SendButton2" name="submit" class="button button-transparent" value="Sign In" /></p>

                            <p class="sign-link">Don't have account? <a href="#">Sign Up</a></p>
                                
                            </div>
                            <!-- END .panel-container -->
                        </form>
                   
                    
                    <div class="box success-state" style="margin-top: 10px;">
                        <div id="tick-text3">
                            <img id="tick2" src="images/tick.png" alt="Success" /> 
                            <div id="tick-text4">Thank you for signing up with us. Your application is being reviewed and will hear back from us within 48 hours.</div>
                            <div class="clear-float"></div>
                        </div>
                        <!-- END #tick-text -->
                        
                       
                
                    </div>
                    <!-- END .box .success-state -->
            
                </div>
                <!-- END .box-wrap -->
                
           
                
            </div>
            <!-- END #animation-form -->
            
        </div>
        <!-- END #background -->

        <div class="background" id="forget">
            <div class="cross"></div>
            <div id="animation-form3">
                <div class="box-wrap" id="box-forget">                                          
                    <!--<h1>Login</h1>-->
                    <form action="forget.php" class="signin-form" id="subForm2" method="post">
                        <input type="hidden" name="tryout" value="1">
                        <div class="panel-container">
                            <table class="responsive-table">
                            <tbody>                                       
                                <tr>
                                    <td>  
                                        <label for="user_email">Email:</label>
                                    </td>                                            
                                </tr>
                                <tr>
                                    <td width="100%">  
                                        <!--<input class="input" id="user_email" name="user_email" placeholder="Enter your email" value="Enter your email" onFocus="if (this.value == 'Enter your email') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Enter your email';}" required type="email">-->
                                        <input style="width:400px;" class="input" id="user_email" name="user_email" placeholder="Enter your email" value="Enter your email" onFocus="if (this.value == 'Enter your email') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Enter your email';}" >
                                    </td>                                           
                                </tr>          
                            </tbody>
                            </table>
                            
                            <p class="submit-row"><input type="submit" id="SendButton2" name="submit" class="button button-transparent" value="Get Password" /></p>
                                
                        </div>
                        <!-- END .panel-container -->
                    </form>
                    <div class="box success-state" style="margin-top: 100px;">
                        <div id="tick-text3">
                            <img id="tick2" src="images/tick.png" alt="Success" /> 
                            <div id="tick-text4">Your password has been sent to your email, please check eamil.</div>
                            <div class="clear-float"></div>
                        </div>
                        <!-- END #tick-text -->
                    </div>
                    <!-- END .box .success-state -->
            
                </div>
                <!-- END .box-wrap -->
                
           
                
            </div>
            <!-- END #animation-form -->
            
        </div>

        
        <!-- BEGIN HEADER -->
        <div class="top-bar">	
            <div class="inner-container">
                <a class="top"><img class="logo" src="images/logo.png" alt="logo"></a>
                <nav class="main-navigation" id="site-navigation">
                    <h3 class="menu-toggle">Menu</h3>
                    <div class="button black-btn">Login</div>                     
                    <ul class="nav-menu">
                        <li class="menu-item current-menu-item" id="go-home"><a href="#">Home</a>
                           
                            
                        </li>
                      
                        
                        <li class="menu-item" id="go-sum"><a href="#summary-mobile">How it Works</a></li>
                       
                        
                        
                        <li class="menu-item" id="go-pub"><a href="#mobile-pub">Publishers</a></li>
                        <li class="menu-item" id="go-advert"><a href="#mobile-advert">Advertisers</a></li>
                        
                        <li class="menu-item" id="go-about"><a href="#mobile-about">About</a></li>
                        <li class="menu-item" id="go-contact"><a href="#mobile-contact-us">Contact</a></li>
                    </ul>
                    <!-- .nav-menu -->
                   
                </nav>

                <!-- #site-navigation -->
                
                <div class="clear-float"></div>
            </div>
            <!-- END .inner-container -->
         
        </div>
        <!-- END .top-bar -->
        
        <!-- END HEADER -->
        
        <!-- BEGIN CONTENT -->
            
        <div id="mobile-devices">
        	<div class="mobile-background-greyscale"></div>
            <img class="mobile-background-image" src="images/bg-2.jpg" alt="image-box-background">
            
            <div class="mobile-page-container">
            	<div class="background-image-box">
                    <h1>The Most Advanced Pay Per Install Network.</h1>
                    <h2>Bringing the monetization of software installs and distribution of offers to the next level.</h2>
                    <div class="notify-button button-green">Join Us!</div>
                    
                </div>
                <!-- END .background-image-box -->
                
                <div class="white-bg" id="summary-mobile">
                    <div class="middle-container">
                       <h1>How It Works</h1>
                            <h2>Install<span>Metrix</span> process:</h2>

                           

                                <div class="panel-container">
                                        <table class="responsive-table">
                                            <tbody>
                                                <tr>
                                                    <td>    

                                                    <div class="panel-icon">
                                                        <p><span class="icon1"></span></p>
                                                        <h3>1. User Downloads and Installs Software</h3> 
                                                    </div>                     
                                                                                                           
                                                    </td>
                                                    <td>     
                                                    <div class="panel-icon">
                                                        <p><span class="icon2"></span></p>
                                                        <h3>2. User is Displayed Relevant Software Offers</h3> 
                                                    </div>                               
                                                       
                                                    </td>
                                                    <td> 
                                                    <div class="panel-icon">
                                                        <p><span class="icon3"></span></p>
                                                        <h3>3. User Can Accept or Decline Offers</h3> 
                                                    </div>                                 
                                                                                                   
                                                    </td>

                                                    <td>   
                                                    <div class="panel-icon">
                                                        <p><span class="icon4"></span></p>
                                                        <h3>4. Upon Accepting Offers, Revenue is Generated</h3> 
                                                    </div>                               
                                                                                                 
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- END .responsive-table -->  
                                        
                                    </div>
                                    <!-- END .panel-container -->
                            
                            <div class="sub-title">
                                <p>Whether you are a Publisher, Advertiser, Developer, Affiliate, Media Buyer, Site Owner or Company Conglomerate; we can help achieve your monetary goals.</p>
                            </div>
                            <!-- END .sub-title -->

                        <div class="table-browser">
                            <div class="browser-container">
                                <div class="browser-top">
                                    <div class="browser-buttons"></div>
                                    <div class="browser-buttons"></div>
                                    <div class="browser-buttons"></div>
                                    <div class="clear-float"></div>
                                </div>
                                <!-- END .browser-top -->
                    
                                <img class="browser-image" src="images/ss-dash2.png" alt="Browser Image">
                            </div>
                            <!-- END .browser-container -->
                        
                        </div>
                        <div class="table-tick">
                            <table class="table-tick-2">
                                <tbody>
                                    <tr>
                                        <td class="table-tick-right">
                                            <img class="tick-i" src="images/tick.png" alt="Tick"/>
                                        </td>
                                        <!-- END .table-tick-right -->
                                        
                                        <td>
                                            <h2>Customized Installer</h2>
                                            <p>Our custom installer designed primarily for Windows systems is at the forefront of technology, allowing us to monetize any Windows-based software in the world. It has the ability to create 100% customizable designs to fit your needs and drive more installs.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-tick-right">
                                            <img class="tick-i" src="images/tick.png" alt="Tick"/>
                                        </td>
                                        <!-- END .table-tick-right -->
                                        
                                        <td>
                                            <h2>Real Time Reporting</h2>
                                            <p>Our user friendly reporting displays your stats as it happens in real time. No longer do you need to experience any delays in tracking your campaigns. Plus, we provide you with the most advanced tracking system to perform in-depth analysis of all your campaigns.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-tick-right">
                                            <img class="tick-i" src="images/tick.png" alt="Tick"/>
                                        </td>
                                        <!-- END .table-tick-right -->
                                        
                                        <td>
                                            <h2>Optimization Technology</h2>
                                            <p>We take the grunt off the work involved in looking at statistical data. Our proprietary analysis protocol in looking at metrics is automated in optimizing the fastest quality distribution and highest revenue earnings per installation.</p>
                                        </td>
                                    </tr>                                                    
                                </tbody>
                            </table>
                            <!-- END .table-tick-2 -->
                                        
                        </div>
                        <!-- END .table-tick -->
                        
                        <div class="clear-float"></div>
                    
                    </div>
                    <!-- END .middle-container -->
                
                </div>
                <!-- END .white-bg -->
                
                <div class="dark-bg" id="mobile-pub">
                   <div class="middle-container">
                        
                           <h1>Publishers</h1>
                           <p><span class="icon_pub"></span></p>
                           <p>We provide you with the highest revenue rates in the industry to ensure your bottom line is always met. Relevant top offers are shown and optimized throughout the installation process to ensure proper conversion metrics.

                            Work with only the best in the field. Sign up is quick and easy. Just distribute to get downloads and reap the benefits of monetization. Watch your earnings in our custom analytics and reporting interface. Our auto optimizer takes tailor implemented algorithms to increase your earnings all in one easy place.</p>

                   
                        <!-- END .dark -->
                        <div class="panel-container">
                            <table class="responsive-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="panel">
                                                <p><span class="icon5"></span></p>
                                                <div class="white-btn">Sign Up as a Publisher</div>
                                               
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                        </td>
                                        <td>
                                            <div class="panel">
                                               <p><span class="icon6"></span></p>
                                               <p>We bundle optional offers to your software.<br>You distribute a custom built download link to your users.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                         </td>
                                         <td>
                                             <div class="panel">
                                                <p><span class="icon7"></span></p>
                                                <p>Watch your money start rolling in.<br>Earn up to $2.00 per install.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                         </td>
                                      </tr>
                                    </tbody>
                                  </table>  
                            </div>
                            <!-- END .panel-container -->
                            
                            <div class="border-text">
                            <h2>Who can be a Publisher?</h2>
                            <p>Anyone who can get people to download software can be a publisher. This includes affiliates, online marketers, media buyers, software developers, site owners, bloggers, etc. For example, if you host a site with software downloads, we can help you earn money everytime someone downloads software from your site. If you are a software developer who wants to monetize your software while still offering it for free, we can help you. If you are an affiliate looking to promote something other than an oversaturated CPA offer, we can help you. The opportunities and possibilities are endless as an InstallMetrix publisher.</p>
                            </div>

                             <div class="white-btn">Sign Up as a Publisher</div>
                    
                        </div>
                        <!-- END .middle-container -->
                
                </div>
                <!-- END .dark-bg -->
                
                <div class="white-bg" id="mobile-advert">
                   <div class="middle-container">
                            <h1>Advertisers</h1>
                            <p><span class="icon_ad"></span></p>
                             <div class="panel-container">
                            <table class="responsive-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="panel">
                                                <p><span class="icon5"></span></p>
                                                <div class="black-btn">Sign Up as a Advertiser</div>
                                               
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                        </td>
                                        <td>
                                            <div class="panel">
                                               <p><span class="icon6"></span></p>
                                               <p>We bundle your offer with our publishers software.<br>Our publishers distribute their software to the masses.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                         </td>
                                         <td>
                                             <div class="panel">
                                                <p><span class="icon7"></span></p>
                                                <p>Watch your installs start rolling in.<br>Over 100,000+ installs daily.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                         </td>
                                      </tr>
                                    </tbody>
                                  </table>  
                            </div>
                            <!-- END .panel-container -->

                            <div class="border-text">
                                <h2>Install Quality Meets Quantity</h2>
                                <p>InstallMetrix strives to bring its advertisers only quality installs while meeting their high volume demands. Our publishers go through a strict review process before being accepted into our network to ensure that we are delivering installs that satisfy your needs. With a zero tolerance policy towards fraud, our dedicated compliance team and anti-fraud technology allows our advertisers to sit back and watch the installs come in. While delivering high quality installs is our number one priority, we also have the ability to deliver a high volume of installs. Whether you have a small or large budget, let InstallMetrix help you reach your goals.</p>
                            </div>

                             <div class="black-btn">Sign Up as a Advertiser</div>
                                
                        </div>
                        <!-- END .middle-container -->
            
                </div>
                <!-- END .white-bg -->
                
                <div class="dark-bg">
                    <div class="middle-container">
                        <h1>Why Publishers and Advertisers Choose Us</h1>

                        <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="panel">
                                                    <div class="speech-container">
                                                        <div class="speech-container-inside">
                                                            <p>I have tested several PPI Networks and InstallMetrix generates the highest revenue for my installs by a longshot!</p>
                                                        </div>
                                                        <!-- END .speech-container-inside -->
                                                        
                                                    </div>
                                                    <!-- END .speech-container -->
                                                    
                                                    <div class="speech-arrow"></div>
                                                    <img width="400" height="400" src="images/client1.jpg" class="profile-image" alt="test_1" />                                                 <div class="profile-name">Wayne</div>
                                                    <div class="profile-name-2">Publisher</div>
                                                </div>
                                                <!-- END .panel -->
                                            
                                            </td>
                                            <td>
                                                <div class="panel">
                                                    <div class="speech-container">
                                                        <div class="speech-container-inside">
                                                            <p>The team at InstallMetrix is a pleasure to work with. They definitely drive a high volume of quality installs to our toolbar offer.</p>
                                                        </div>
                                                        <!-- END .speech-container-inside -->
                                                    
                                                    </div>
                                                    <!-- END .speech-container -->
                                                    
                                                    <div class="speech-arrow"></div>
                                                    <img width="650" height="650" src="images/client2.jpg" class="profile-image" alt="test_3" />                                                 <div class="profile-name">Israel</div>
                                                    <div class="profile-name-2">Advertiser</div>
                                                </div>
                                                <!-- END .panel -->
                                                
                                             </td>
                                             <td>
                                                <div class="panel">
                                                    <div class="speech-container">
                                                        <div class="speech-container-inside">
                                                            <p>InstallMetrix has taken my earnings from $250/day to over $5,000/day within a month. A big thanks goes out to my account manager!</p>
                                                        </div>
                                                        <!-- END .speech-container-inside -->
                                                    
                                                    </div>
                                                    <!-- END .speech-container -->
                                                    
                                                    <div class="speech-arrow"></div>
                                                    <img width="400" height="400" src="images/client3.jpg" class="profile-image" alt="test_2" />                                                 <div class="profile-name">Colin</div>
                                                    <div class="profile-name-2">Publisher</div>
                                                </div>
                                                <!-- END .panel -->
                                             
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                            
                            </div>
                            <!-- END .panel-container -->
                       
                        
                    </div>
                    <!-- END .middle-container -->
                
                </div>
                <!-- END .dark-bg -->
                
                <div class="white-bg" id="mobile-about">
                    <div class="middle-container">
                        <h1>About</h1>

                          <div class="sub-title">
                            <p>Based out of San Francisco, InstallMetrix is a Pay Per Install network  that focuses on driving quality installs at a high volume. We help publishers monetize their software and give advertisers another channel for distribution. Our mission is to provide publishers and advertisers first class service that is currently lacking from the pay per install industry. Not only will we provide you with the tools to succeed, but we will also do whatever it takes to help our partners grow.</p>
                        </div>


                         <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>                          
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Innovators</h2>
                                                  <p>InstallMetrix is the leading Pay Per Install network that prides itself as innovators of the industry. Where copy cats are common, we continue to create new ideas and are always pushing towards the next frontier.</p>
                                                
                                                </div>

                                                </div>   
                                            
                                            </td>
                                            <td>                                   
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Our Passion</h2>
                                                       <p>Not only are we passionate about this business, but we are also heavily invested into the relationships we make with our publishers and advertisers. We believe that in order to grow, we must help everybody around us to grow as well.</p>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                
                                                </div>   
                                            </td>
                                           
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END .responsive-table -->  
                                
                            </div>
                            <!-- END .panel-container -->

                       
                        
                    </div>
                    <!-- END .middle-container -->
                    
                </div>
                <!-- END .white-bg -->
                
                <div class="dark-bg">
                    <div class="middle-container">
                        <h1>Careers and Partnerships</h1>


                         <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>                          
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Team</h2>
                                                        <p>Our core is our team dynamics in how we operate.  As programmers, engineers, developers, marketing executives, distribution directors, and business managers, we all have a passion in our jobs to work like a well oil machine.</p>
                                                        

                                                     </div>
                                                    <!-- END .panel-plan-container -->
                                                    <div class="button button-green">Learn More</div>
                                                
                                                </div>   
                                            
                                            </td>
                                            <td>                                   
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Careers</h2>
                                                        <p>We are always looking for hard working and talented people to join our team. Please feel free to contact us on our contact page.</p>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                    <div class="button button-green">Apply Now</div>
                                                
                                                </div>   
                                            </td>
                                            <td>                                 
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Investors</h2>
                                                       <p>Let us help you, by helping us. We are a privately owned debt free software company looking to take it to the next level. Please feel free to contact us on our contact page.</p>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                    <div class="button button-green">Contact Us</div>
                                                
                                                </div>   
                                    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END .responsive-table -->  
                                
                            </div>
                            <!-- END .panel-container -->


                      
                    </div>
                    <!-- END .middle-container -->
            
                </div>
                <!-- END .dark-bg -->
      
                <div class="white-bg">
                    <div class="middle-container">
                        <h1>Questions and answers.</h1>
                        <div class="panel-container">
                            <table class="responsive-table">
                                <tbody>
                                    <tr>
                                        <td>                                                                
                                            <div class="panel-questions">
                                                <div class="panel-questions-container">
                                                    <h2>What is a bundled offer?</h2>
                                                    <p>A bundled offer is an optional 3rd party offer that is shown during the installation process of your main software application. Offers include toolbars, utility programs, software apps, etc.</p>
                                                </div>
                                                <!-- END .panel-questions-container -->
                                            
                                            </div>
                                            <!-- END .panel-questions -->
                                        
                                        </td>
                                        <td>                                          
                                            <div class="panel-questions">
                                                <div class="panel-questions-container">
                                                    <h2>What countries can I promote my bundled software app?</h2>
                                                    <p>Our monetization solution allows you to promote your bundled software app to any country in the world. However, certain countries will yield higher revenues than others.</p>
                                                </div>
                                                <!-- END .panel-questions-container -->
                                            
                                            </div>
                                            <!-- END .panel-questions -->
                                        
                                        </td>
                                        <td>
                                                                                        
                                            <div class="panel-questions">
                                                <div class="panel-questions-container">
                                                    <h2>What are your payment terms?</h2>
                                                    <p>We pay  our publishers on net 30 payment terms. </p>
                                                </div>
                                                <!-- END .panel-questions-container -->
                                            
                                            </div>
                                            <!-- END .panel-questions -->
                                        
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                    
                        </div>
                        <!-- END .panel-container -->
                        
                    </div>
                    <!-- END .middle-container -->
                    
                </div>
                <!-- END .white-bg -->
     
               
                
                


                <div class="dark-bg" id="mobile-contact-us">
                    <div class="middle-container contact-us">
                        <h1>Want to say hello? Want to know more? </h1>

                         <div class="sub-title">
                            <p>Drop us an email and we will get back to you as soon as we can.</p>
                        </div>
                            
                            <div class="panel-container">
                            <form id="contact" action="action" method="post">
                                <table class="responsive-table">
                                
                                    <tbody>
                                        <tr>
                                            <td>                          
                                               
                                                    <div class="panel-plan-container">
                                                        <label for="nameinput">Name: *</label><br>
                                                        <input type="text" id="nameinput" name="name" value=""/><br>
                                                        <label for="emailinput">E-mail: *</label><br>
                                                        <input type="text" id="emailinput" name="email" value=""/><br>
                                                        <label for="phoneinput">Phone: </label><br>
                                                        <input type="text" id="phoneinput" name="phone" value=""/><br>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                
                                               
                                            
                                            </td>
                                            <td>                                   
                                                
                                                    <div class="panel-plan-container">
                                                      <label for="message">Message: *</label><br>
                                                      <textarea cols="10" rows="7" id="message" name="message"></textarea><br>
                                                      <input type="submit" id="submitinput" name="submit" class="button" value="Send"/>
                                                      <input type="hidden" id="receiver" name="receiver" value="your@mail.com"/>
                                
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                
                                                   
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                
                                 
                                
                                </table>
                                <!-- END .responsive-table --> 
                                </form>


                                
                            </div>
                            <!-- END .panel-container -->
               
                    </div>
                    <!-- END .middle-container -->
        
                </div>
                <!-- END .dark-bg -->

                    <div class="footer-panel-mobile">
                        <div class="middle-container-footer">
                            <table class="responsive-table-2">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="footer-call">
                                                <h1>Want to make money with us? Take a look inside.</h1>
                                            </div>
                                            <!-- END .footer-call -->
                                            
                                        </td>
                                        <td>
                                            <div class="footer-button white-btn">Sign Up</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>	
                            <!-- END .footer-table -->
                            
                        </div>
                        <!-- END .middle-container-footer -->
                    
                    </div>
                    <!-- END .footer-panel-mobile -->
                    
                    <div class="footer-bottom-mobile">
                        <div class="middle-container-footer">
                        <img  src="images/logo-footer.png" alt="">
                            <div class="footer-social-links">
                                <ul>
                                     <li>
                                        <a href="#">
                                            <img class="footer-image" src="images/gplus.png" alt="Facebook" />
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <img class="footer-image" src="images/fb.png" alt="Facebook" />
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="footer-image" src="images/twiter.png" alt="Twitter" />
                                        </a>
                                    </li>
                                   
                                    <li>
                                        <a href="mailto:#">
                                            <img class="footer-image" src="images/vimeo.png" alt="Mail" />
                                        </a>
                                    </li>
                                    
                                </ul>
                                <div class="clear-float"></div>
                            </div>
                            <!-- END .footer-social-links -->

                             <div class="footer-contact">
                                
                                <h3>Contact Us</h3>
                                <p>San Francisco, California</p>
                                <p>(415) 675 8894</p>
                                <p>contact@installmetrix.com</p>


                            </div>

                             <div class="newsletter">
                                <h3>Join Our Newsletter</h3>
                                 <form action="action" class="newsletter-form" id="newsForm2" method="post">
                                <input id="news-email2" name="news-email"  value="Email adress" onFocus="if (this.value == 'Email adress') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Email adress';}"><br>
                                <input type="submit" id="submitinput3" name="submit" class="button" value="Send"/>
                                <input type="hidden" id="receiver3" name="receiver" value="your@email.com"/>
                                </form>
                            </div>
                            
                           <div class="disclaimer">

                                <ul>
                                    <li>
                                        <a href="terms.html">Terms and Conditions</a>
                                    </li>
                                    <li>
                                        <a href="privacy.html">Privacy</a>
                                    </li>
                                    <li>
                                        <a href="uninstall.html">Uninstall</a>
                                    </li>
                                </ul>
                                <hr>
                                2013 &copy; All right reserved. 

                            </div>
                            <!--END .disclaimer -->
                            
                            <div class="clear-float"></div>
                        </div>
                        <!--END .middle-container-footer -->
                        
                    </div>
                    <!--END .footer-bottom-mobile -->     
                
                </div>
                <!--END .mobile-page-container -->
           
           </div>
           <!--END #mobile-devices -->
           
           <div id="wrapper">
               
                
                <div id="footer">
                    <div id="footer-bottom-panel">
                        <div class="middle-container-footer">
                        <img  src="images/logo.png" alt="">
                            <div class="footer-links">
                                 <ul class="nav-menu">
                                        <li class="menu-item " id="go-home-footer"><a href="#">Home</a></li>
                                        <li class="menu-item" id="go-sum-footer"><a href="#summary-mobile">How it Works</a></li>
                                        <li class="menu-item" id="go-pub-footer"><a href="#mobile-pub">Publishers</a></li>
                                        <li class="menu-item" id="go-advert-footer"><a href="#mobile-advert">Advertisers</a></li>
                                        <li class="menu-item" id="go-about-footer"><a href="#mobile-about">About</a></li>
                                        <li class="menu-item" id="go-contact-footer"><a href="#mobile-contact-us">Contact</a></li>
                                    </ul>
                            </div>
                            <!--END .footer-social-links -->


                            <ul class="footer-social">
                                <li class="facebook"><a href="#"></a></li>
                                <li class="gplus"><a href="#"></a></li>
                                <li class="twitter"><a href="#"></a></li>
                                <li class="vimeo"><a href="#"></a></li>

                            </ul>

                            <div class="footer-contact">
                                
                                <h3>Contact Us</h3>
                                <p>San Francisco, California</p>
                                <p>(415) 675 8894</p>
                                <p>contact@installmetrix.com</p>


                            </div>
                            
                            <div class="disclaimer">

                                <ul>
                                    <li>
                                        <a href="terms.html">Terms and Conditions</a>
                                    </li>
                                    <li>
                                        <a href="privacy.html">Privacy</a>
                                    </li>
                                    <li>
                                        <a href="uninstall.html">Uninstall</a>
                                    </li>
                                </ul>
                                <hr>
                                2013 &copy; All right reserved. 

                            </div>
                            <!--END .disclaimer -->

                            <div class="newsletter">
                                <h3>Join Our Newsletter</h3>
                                 <form action="action" class="newsletter-form" id="newsForm" method="post">
                                <input id="news-email" name="news-email" value="Email adress"><br>
                                <input type="submit" id="submitinput4" name="submit" class="button" value="Send"/>
                                <input type="hidden" id="receiver4" name="receiver" value="your@email.com"/>
                                </form>
                            </div>
                            
                            <div class="clear-float"></div>
                        </div>
                        <!--END .middle-container-footer -->
                        
                    </div>
                    <!--END #footer-bottom-panel -->
                         
                </div>
                <!--END #footer -->
                
                <div id="parallax-footer">
                    <div id="footer-panel">
                        <div class="middle-container-footer">
                            <table class="responsive-table-2">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="footer-call">
                                                <h1>Want to make money with us? Take a look inside.</h1>
                                            </div>
                                            <!-- END .footer-call -->
                                            
                                        </td>
                                        <td>
                                            <div class="footer-button white-btn">Sign Up</div>
                                            <div class="clear-float"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>	
                            <!--END .responsive-table-2 -->
                           
                        </div>
                        <!--END .middle-container-footer -->
                    
                    </div>
                    <!--END #footer-panel -->
                    
                </div>
                <!--END #parallax-footer -->
            
                <div id="parallax-panel-content">
                    <div id="summary">
                        <div class="middle-container">
                            <h1>How It Works</h1>
                            <h2 class="subheading">Install<span>Metrix</span> process:</h2>

                           

                                <div class="panel-container">
                                        <table class="responsive-table">
                                            <tbody>
                                                <tr>
                                                    <td>    

                                                    <div class="panel-icon">
                                                        <p><span class="icon1"></span></p>
                                                        <h3>1. User Downloads and Installs Software</h3> 
                                                    </div>                     
                                                                                                           
                                                    </td>
                                                    <td>     
                                                    <div class="panel-icon">
                                                        <p><span class="icon2"></span></p>
                                                        <h3>2. User is Displayed Relevant Software Offers</h3> 
                                                    </div>                               
                                                       
                                                    </td>
                                                    <td> 
                                                    <div class="panel-icon">
                                                        <p><span class="icon3"></span></p>
                                                        <h3>3. User Can Accept or Decline Offers</h3> 
                                                    </div>                                 
                                                                                                   
                                                    </td>

                                                    <td>   
                                                    <div class="panel-icon">
                                                        <p><span class="icon4"></span></p>
                                                        <h3>4. Upon Accepting Offers, Revenue is Generated</h3> 
                                                    </div>                               
                                                                                                 
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- END .responsive-table -->  
                                        
                                    </div>
                                    <!-- END .panel-container -->
                            
                            <div class="sub-title">
                                <p>Whether you are a Publisher, Advertiser, Developer, Affiliate, Media Buyer, Site Owner or Company Conglomerate; we can help achieve your monetary goals.</p>
                            </div>
                            <!-- END .sub-title -->

                            <div class="table-browser">
                                <div class="browser-container">
                                    <div class="browser-top">
                                        <div class="browser-buttons"></div>
                                        <div class="browser-buttons"></div>
                                        <div class="browser-buttons"></div>
                                        <div class="clear-float"></div>
                                    </div>
                                    <!-- END .browser-top -->
                        
                                    <img class="browser-image" src="images/ss-dash2.png" alt="Browser Image">
                                </div>
                                <!-- END .browser-container -->
                            
                            </div>
                            <div class="table-tick">
                                <table class="table-tick-2">
                                    <tbody>
                                        <tr>
                                            <td class="table-tick-right">
                                                <img class="tick-i" src="images/tick.png" alt="Tick"/>
                                            </td>
                                            <!-- END .table-tick-right -->
                                            
                                            <td>
                                                <h2>Customized Installer</h2>
                                                <p>Our custom installer designed primarily for Windows systems is at the forefront of technology, allowing us to monetize any Windows-based software in the world. It has the ability to create 100% customizable designs to fit your needs and drive more installs.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-tick-right">
                                                <img class="tick-i" src="images/tick.png" alt="Tick"/>
                                            </td>
                                            <!-- END .table-tick-right -->
                                            
                                            <td>
                                                <h2>Real Time Reporting</h2>
                                                <p>Our user friendly reporting displays your stats as it happens in real time. No longer do you need to experience any delays in tracking your campaigns. Plus, we provide you with the most advanced tracking system to perform in-depth analysis of all your campaigns.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-tick-right">
                                                <img class="tick-i" src="images/tick.png" alt="Tick"/>
                                            </td>
                                            <!-- END .table-tick-right -->
                                            
                                            <td>
                                                <h2>Optimization Technology</h2>
                                                <p>We take the grunt off the work involved in looking at statistical data. Our proprietary analysis protocol in looking at metrics is automated in optimizing the fastest quality distribution and highest revenue earnings per installation.</p>
                                            </td>
                                        </tr>                                                    
                                    </tbody>
                                </table>
                                <!-- END .table-tick-2 -->
                                            
                            </div>
                            <!-- END .table-tick -->
                            
                            <div class="clear-float"></div>
                        
                        </div>
                        <!-- END .middle-container -->
                    
                    </div>
                    <!-- END #summary -->
                    
                    <div id="advert">
                        <div class="middle-container">
                            <h1>Advertisers</h1>
                            <p><span class="icon_ad"></span></p>
                             <div class="panel-container">
                            <table class="responsive-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="panel">
                                                <p><span class="icon5"></span></p>
                                                <div class="black-btn">Sign Up as a Advertiser</div>
                                               
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                        </td>
                                        <td>
                                            <div class="panel">
                                               <p><span class="icon6"></span></p>
                                               <p>We bundle your offer with our publishers software.<br>Our publishers distribute their software to the masses.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                         </td>
                                         <td>
                                             <div class="panel">
                                                <p><span class="icon7"></span></p>
                                                <p>Watch your installs start rolling in.<br>Over 100,000+ installs daily.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                         </td>
                                      </tr>
                                    </tbody>
                                  </table>  
                            </div>
                            <!-- END .panel-container -->

                            <div class="border-text">
                                <h2>Install Quality Meets Quantity</h2>
                                <p>InstallMetrix strives to bring its advertisers only quality installs while meeting their high volume demands. Our publishers go through a strict review process before being accepted into our network to ensure that we are delivering installs that satisfy your needs. With a zero tolerance policy towards fraud, our dedicated compliance team and anti-fraud technology allows our advertisers to sit back and watch the installs come in. While delivering high quality installs is our number one priority, we also have the ability to deliver a high volume of installs. Whether you have a small or large budget, let InstallMetrix help you reach your goals.</p>
                            </div>

                             <div class="black-btn">Sign Up as a Advertiser</div>
                                
                        </div>
                        <!-- END .middle-container -->
                  
                    </div>
                    <!-- END #screenshots -->
                          
					<div id="about">
                        <div class="middle-container">
                            <h1>About</h1>

                              <div class="sub-title">
                            <p>Based out of San Francisco, InstallMetrix is a Pay Per Install network  that focuses on driving quality installs at a high volume. We help publishers monetize their software and give advertisers another channel for distribution. Our mission is to provide publishers and advertisers first class service that is currently lacking from the pay per install industry. Not only will we provide you with the tools to succeed, but we will also do whatever it takes to help our partners grow.</p>
                        </div>

                         <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>                          
                                              
                                                    <div class="panel-plan-container">
                                                        <h2>Innovators</h2>
                                                  <p>InstallMetrix is the leading Pay Per Install network that prides itself as innovators of the industry. Where copy cats are common, we continue to create new ideas and are always pushing towards the next frontier. Throughout the years of our online adventures, our team has consistently developed strategies and products that have impacted the industry for years to come. InstallMetrix was built to solve the rudimentary tracking and optimization capabilities that other pay per install networks currently provide. After 1 full year of dedicated coding and countless tests, we have developed the most advanced pay per install network in the world.</p>
                                                
                                                </div>   
                                            
                                            </td>
                                            <td>                                   
                                                
                                                    <div class="panel-plan-container">
                                                        <h2>Our Passion</h2>
                                                       <p>Not only are we passionate about the service we provide, but we are also heavily invested into the relationships we make with our publishers and advertisers. We believe that in order to grow, we must help everybody around us to grow as well. With dedicated account managers for both our publishers and advertisers, we are able to satisfy all requests with lightning fast results. Whether you want to chat on the phone or message us online, we make ourselves available anytime you need us. This is our life and we know you'll enjoy working with our extremely personable and down-to-earth team.</p>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                
                                                 
                                            </td>
                                           
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END .responsive-table -->  
                                
                            </div>
                            <!-- END .panel-container -->
                           
                            
                        </div>
                        <!-- END .middle-container -->
                        
                    </div>
                    <!-- END #iphones -->
                            
					<div id="questions">	
                       <div class="middle-container">
                            <h1>Questions and answers.</h1>
                            <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>                                                                
                                                <div class="panel-questions">
                                                    <div class="panel-questions-container">
                                                        <h2>What is a bundled offer?</h2>
                                                        <p>A bundled offer is an optional 3rd party offer that is shown during the installation process of your main software application. Offers include toolbars, utility programs, software apps, etc.</p>
                                                    </div>
                                                    <!-- END .panel-questions-container -->
                                                
                                                </div>
                                                <!-- END .panel-questions -->
                                            
                                            </td>
                                            <td>                                          
                                                <div class="panel-questions">
                                                    <div class="panel-questions-container">
                                                        <h2>What countries can I promote my bundled software app?</h2>
                                                        <p>Our monetization solution allows you to promote your bundled software app to any country in the world. However, certain countries will yield higher revenues than others.</p>
                                                    </div>
                                                    <!-- END .panel-questions-container -->
                                                
                                                </div>
                                                <!-- END .panel-questions -->
                                            
                                            </td>
                                            <td>
                                                                                            
                                                <div class="panel-questions">
                                                    <div class="panel-questions-container">
                                                        <h2>What are your payment terms?</h2>
                                                        <p>We pay our publishers on net 30 payment terms.</p>
                                                    </div>
                                                    <!-- END .panel-questions-container -->
                                                
                                                </div>
                                                <!-- END .panel-questions -->
                                            
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                        
                            </div>
                            <!-- END .panel-container -->
                            
                        </div>
                        <!-- END .middle-container -->
                        
                    </div>
                    <!-- END #team -->
                            
					
    
                </div>
                <!-- END #parallax-panel-content -->
                
                <div id="parallax-panels">
                    <div class="white-background" id="bg-1"></div>
                    <div class="white-background" id="bg-2"></div>
                    <div class="white-background" id="bg-3"></div>
                    <div class="white-background" id="bg-4"></div>
                    
                </div>
                <!-- END #parallax-panels -->
                
                <div id="parallax-iphone-banner">
                    <div class="iphone-banner-container">
                        <div class="iphone-banner iphone-light">
                            <div class="iphone-speaker iphone-speaker-light"></div>
                            <img class="iphone-screen" src="images/iphone-left.jpg" alt="iPhone Screen"/>
                            <div class="iphone-button iphone-button-light"></div>
                        </div>
                        <!-- END .iphone-banner #iphone-banner-white -->
                    
                    </div>
                    <!-- END .iphone-banner-container -->
                </div>
                <!-- END #parallax-iphone-banner -->
                
                <div id="parallax-under-content">
                    <div id="publishers">
                        <div class="middle-container">
                        <div class="dark">
                           <h1>Publishers and Developers</h1>
                           <p><span class="icon_pub"></span></p>
                           <p>We provide you with the highest revenue rates in the industry to ensure your bottom line is always met. Relevant top offers are shown and optimized throughout the installation process to ensure proper conversion metrics.

                            Work with only the best in the field. Sign up is quick and easy. Just distribute to get downloads and reap the benefits of monetization. Watch your earnings in our custom analytics and reporting interface. Our auto optimizer takes tailor implemented algorithms to increase your earnings all in one easy place.</p>

                        </div>
                        <!-- END .dark -->
                        <div class="panel-container">
                            <table class="responsive-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="panel">
                                                <p><span class="icon5"></span></p>
                                                <div class="white-btn">Sign Up as a Publisher</div>
                                               
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                        </td>
                                        <td>
                                            <div class="panel">
                                               <p><span class="icon6"></span></p>
                                               <p>We bundle optional offers to your software.<br>You distribute a custom built download link to your users.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                            
                                         </td>
                                         <td>
                                             <div class="panel">
                                                <p><span class="icon7"></span></p>
                                                <p>Watch your money start rolling in.<br>Earn up to $2.00 per install.</p>
                                                
                                            </div>
                                            <!-- END .panel -->
                                         </td>
                                      </tr>
                                    </tbody>
                                  </table>  
                            </div>

                            <!-- END .panel-container -->
                            
                            <div class="border-text">
                            <h2>Who can be a Publisher?</h2>
                            <p>Anyone who can get people to download software can be a publisher. This includes affiliates, online marketers, media buyers, software developers, site owners, bloggers, etc. For example, if you host a site with software downloads, we can help you earn money everytime someone downloads software from your site. If you are a software developer who wants to monetize your software while still offering it for free, we can help you. If you are an affiliate looking to promote something other than an oversaturated CPA offer, we can help you. The opportunities and possibilities are endless as an InstallMetrix publisher.</p>
                            </div>

                             <div class="white-btn">Sign Up as a Publisher</div>
                    
                        </div>
                        <!-- END .middle-container -->
                    
                    </div>
                    <!-- END #features -->
                    
                    <div id="testimon">
                        <div class="middle-container">
                            <div class="dark">
                                <h1>Why Publishers and Advertisers Choose Us</h1>
                            </div>
                            <!-- END .dark -->

                            <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="panel">
                                                    <div class="speech-container">
                                                        <div class="speech-container-inside">
                                                            <p>I have tested several PPI Networks and InstallMetrix generates the highest revenue for my installs by a longshot!</p>
                                                        </div>
                                                        <!-- END .speech-container-inside -->
                                                        
                                                    </div>
                                                    <!-- END .speech-container -->
                                                    
                                                    <div class="speech-arrow"></div>
                                                    <img width="400" height="400" src="images/client1.jpg" class="profile-image" alt="test_1" />                                                 <div class="profile-name">Wayne</div>
                                                    <div class="profile-name-2">Publisher</div>
                                                </div>
                                                <!-- END .panel -->
                                            
                                            </td>
                                            <td>
                                                <div class="panel">
                                                    <div class="speech-container">
                                                        <div class="speech-container-inside">
                                                            <p>The team at InstallMetrix is a pleasure to work with. They definitely drive a high volume of quality installs to our toolbar offer.</p>
                                                        </div>
                                                        <!-- END .speech-container-inside -->
                                                    
                                                    </div>
                                                    <!-- END .speech-container -->
                                                    
                                                    <div class="speech-arrow"></div>
                                                    <img width="650" height="650" src="images/client2.jpg" class="profile-image" alt="test_3" />                                                 <div class="profile-name">Israel</div>
                                                    <div class="profile-name-2">Advertiser</div>
                                                </div>
                                                <!-- END .panel -->
                                                
                                             </td>
                                             <td>
                                                <div class="panel">
                                                    <div class="speech-container">
                                                        <div class="speech-container-inside">
                                                            <p>InstallMetrix has taken my earnings from $250/day to over $5,000/day within a month. A big thanks goes out to my account manager!</p>
                                                        </div>
                                                        <!-- END .speech-container-inside -->
                                                    
                                                    </div>
                                                    <!-- END .speech-container -->
                                                    
                                                    <div class="speech-arrow"></div>
                                                    <img width="400" height="400" src="images/client3.jpg" class="profile-image" alt="test_2" />                                                 <div class="profile-name">Colin</div>
                                                    <div class="profile-name-2">Advertiser</div>
                                                </div>
                                                <!-- END .panel -->
                                             
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                            
                            </div>
                            <!-- END .panel-container -->
                            
                            
                            
                        </div>
                        <!-- END .middle-container -->
                        
                        </div>
                        <!-- END #ipad -->
            
                    	<div id="lorem">
                        <div class="middle-container">
                            <div class="dark">
                                <h1>Careers and Partnerships</h1>
                            </div>
                            <!-- END .dark -->

                            <div class="panel-container">
                                <table class="responsive-table">
                                    <tbody>
                                        <tr>
                                            <td>                          
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Team</h2>
                                                        <p>Our core is our team dynamics in how we operate.  As programmers, engineers, developers, marketing executives, distribution directors, and business managers, we all have a passion in our jobs to work like a well oil machine.</p>

                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                    <div class="button button-green">Learn More</div> 

                                                
                                                </div> 

                                            
                                            </td>
                                            <td>                                   
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Careers</h2>
                                                        <p>We are always looking for hard working and talented people to join our team. Please feel free to contact us on our contact page.</p>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                     <div class="button button-green">Apply Now</div> 
                                                
                                                </div>   
                                            </td>
                                            <td>                                 
                                                <div class="panel-plan panel-border">
                                                    <div class="panel-plan-container">
                                                        <h2>Investors</h2>
                                                       <p>Let us help you, by helping us. We are a privately owned debt free software company looking to take it to the next level. Please feel free to contact us on our contact page.</p>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                     <div class="button button-green">Contact Us</div>
                                                
                                                </div>   
                                    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END .responsive-table -->  
                                
                            </div>
                            <!-- END .panel-container -->
                            
                           
                            
                        </div>
                        <!-- END .middle-container -->
            
                    </div>
                    <!-- END #testimonials -->
                        
                   


                    <div id="contact-us" class="contact-us">
                        <div class="middle-container">
                            <div class="dark">
                                <h1>Want to say hello? Want to know more? </h1>
                            </div>
                            <!-- END .dark -->

                             <div class="sub-title">
                            <p>Drop us an email and we will get back to you as soon as we can.</p>
                        </div>
                            
                            <div class="panel-container">
                            <form id="contact2" action="action" method="post">
                                <table class="responsive-table">
                                
                                    <tbody>
                                        <tr>
                                            <td>                          
                                                <div class="">
                                                    <div class="panel-plan-container">
                                                        <label for="nameinput2">Name: *</label><br>
                                                        <input type="text" id="nameinput2" name="name" value=""/><br>
                                                        <label for="emailinput2">E-mail: *</label><br>
                                                        <input type="text" id="emailinput2" name="email" value=""/><br>
                                                        <label for="phoneinput2">Phone: </label><br>
                                                        <input type="text" id="phoneinput2" name="phone" value=""/><br>
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                
                                                </div>   
                                            
                                            </td>
                                            <td>                                   
                                                <div class="">
                                                    <div class="panel-plan-container">
                                                      <label for="commentinput2">Message: *</label><br>
                                                      <textarea cols="10" rows="7" id="commentinput2" name="comment"></textarea><br>
                                                      <input type="submit" id="submitinput2" name="submit" class="button" value="Send"/>
                                                         <input type="hidden" id="receiver2" name="receiver" value=""/>
                                
                                                    </div>
                                                    <!-- END .panel-plan-container -->
                                                
                                                </div>   
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                    
                                </table>
                                <!-- END .responsive-table -->  
                                </form>
                                
                            </div>
                            <!-- END .panel-container -->
                   
                        </div>
                        <!-- END .middle-container -->
        
                    </div>
                    <!-- END #price-plans -->
           
            </div>
            <!-- END #parallax-under-content -->
        
            <div id="parallax-macbook">
                <div class="macbook-container">
                    <div class="macbook">
                        <div class="macbook-camera"></div>
                        <div class="macbook-screen-container">
                            <img class="macbook-screen" src="images/ss-dash1.png" alt="browser-screen">
                        </div>
                        <!-- END .macbook-screen-2 -->
                        
                        <div class="macbook_base">
                            <div class="macbook_base-hole"></div>	
                        </div>	
                        <!-- END .macbook_base -->
                        
                    </div>
                    <!-- END .macbook -->
                    
                    <div class="clear-float"></div>
                </div>
                <!-- END .macbook-container -->
                    
            </div>
            <!-- END #parallax-macbook -->
            
            <div id="parallax-banner-text">
                <div class="image-box-text">
                    <h1>The Most Advanced Pay Per Install Network.</h1>
                    <h2>Bringing the monetization of software installs and distribution of offers to the next level.</h2>
                    <div class="notify-button button-green">Join Us!</div>
                </div>
                <!-- END .image-box-text -->
                
            </div>
            <!-- END #parallax-banner-text -->
            
            <div id="parallax-background">
                <div class="background-greyscale"></div>
                <img class="background-image" src="images/bg-2.jpg" alt="Background Image">
            </div>
            <!-- END #parallax-background -->
            
		</div>
        <!-- END #wrapper -->

	</body>
</html>    
