<div class="footer">
    <div class="page-container footer-container">
        <div class="footer-cities">
            <div class="footer-city">
                <a href="property_list.php?city=Delhi">PG in Delhi</a>
            </div>
            <div class="footer-city">
                <a href="property_list.php?city=Mumbai">PG in Mumbai</a>
            </div>
            <div class="footer-city">
                <a href="property_list.php?city=Bengaluru">PG in Bangalore</a>
            </div>
            <div class="footer-city">
                <a href="property_list.php?city=Hyderabad">PG in Hyderabad</a>
            </div>
        </div>
         <div class="footer-social">
            <a href="https://facebook.com" target="_blank" class="social-link">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
            <span class="divider">|</span>
            <a href="https://instagram.com" target="_blank" class="social-link">
                <i class="fab fa-instagram"></i>
                <span>Instagram</span>
            </a>
            <span class="divider">|</span>
            <a href="https://twitter.com" target="_blank" class="social-link">
                <i class="fab fa-twitter"></i>
                <span>Twitter</span>
            </a>
            <span class="divider">|</span>
            <a href="https://linkedin.com" target="_blank" class="social-link">
                <i class="fab fa-linkedin-in"></i>
                <span>LinkedIn</span>
            </a>
           
        </div>
    </div>
</div>

<style>
    .footer {
  

         background-color: #333333;
    font-size: 13px;
    margin-top: 50px;
    height: 220px;
    position: relative; 
    bottom: 0;
    width: 100%;
}
  


    .footer-container {
        display: flex;
        flex-direction: column;
        height: 220px;
    }
    
    .footer-cities {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
        margin-bottom: 25px;
    }
    
    .footer-city a {
        color: #ffffff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .footer-city a:hover {
        color: #4b6cb7;
    }
    
    .footer-social {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid #ffffff;
    }
    
    .social-link {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 0 10px;
    }
    
    .social-link:hover {
        color: #4b6cb7;
        transform: translateY(-2px);
    }
    
    .social-link i {
        font-size: 18px;
    }
    
    .divider {
        color: #ffffff;
        font-weight: 300;
        user-select: none;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    
   
    @media (max-width: 768px) {
        .footer-cities {
            gap: 15px;
        }
        
        .footer-social {
            gap: 10px;
        }
        
        .divider {
            display: none;
        }
        
        .social-link {
            padding: 5px;
        }
    }





</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
