<style>
/*loading*/
@import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,400;0,700;1,400;1,700&display=swap');

.sc-overlay {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transform: -webkit-translate(-50%, -50%);
    transform: -moz-translate(-50%, -50%);
    transform: -ms-translate(-50%, -50%);
    color:#1f222b;
    z-index: 9999;
    background: rgba(255,255,255,0.7);
  }
  
  #sc-loading{
    display: none;
    position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 50;
      background: rgba(255,255,255,0.7);
  }
  /*end loading */

  /*price*/
  
.sc-new-price{
    color:#FE980F;
    font-size: 20px;
    padding: 10px;
    font-weight:bold;
  }
  .sc-old-price {
    text-decoration: line-through;
    color: #a95d5d;
    font-size: 17px;
    padding: 10px;
  }
  /*end price*/
.sc-product-build{
  font-size: 20px;
  font-weight: bold;
}
.sc-product-build img{
  width: 50px;
}
.sc-product-group  img{
    width: 100px;
    cursor: pointer;
  }
.sc-product-group:hover{
  box-shadow: 0px 0px 2px #999;
}
.sc-product-group:active{
  box-shadow: 0px 0px 2px #ff00ff;
}
.sc-product-group.active{
  box-shadow: 0px 0px 2px #ff00ff;
}

.sc-shipping-address td{
  padding: 3px !important;
}
.sc-shipping-address textarea,
.sc-shipping-address input[type="text"],
.sc-shipping-address option{
  width: 100%;
  padding: 7px !important;
}
.row_cart>td{
  vertical-align: middle !important;
}
input[type="number"]{
  text-align: center;
  padding:2px;
}
.sc-notice{
    clear: both;
}

.logo_title {
  font-size: 30px;
  vertical-align: middle;
  color: #4DB848;
  padding-left: 10px;
}

.network-title {
  font-size: 30px; 
  font-weight: 500; 
  text-align: center;
  padding-bottom: 30px;
  font-family: Karla;
}

.m--img-rounded {
  border-radius: 50%;
  height: 130px;
  width: 126px;
  border: solid .5rem;
  border-color: #4DB848;
}

.network-left {
  background: #007ac0;
  height: 280px;
  border-radius: 5px;
  border-top: solid 0.2rem;
  border-top-color: #ffffff;
  box-shadow: 0px 0px 20px #00b0f0c4;
}

.network-right {
  background: #00b0f0;
  height: 280px;
  border-radius: 5px;
  border-top: solid 0.2rem;
  border-top-color: #ffffff;
  box-shadow: 0px 0px 20px #00b0f0c4;
}

.network-img {
  width: 100%; 
  text-align: center; 
  padding: 4rem 0rem 2rem 0rem;
}

.network-img1 {
  width: 130px; 
  text-align: center; 
  border-radius: 50%;
  border: solid .2rem;
  border-color: #ffffff;
}

.network-col {
  color: white; 
  padding: 10px 10px;
  overflow-y: auto;
}

.network-col1 {
  height: 150px;
  color: white; 
  padding: 10px 0px;;
  width: calc(100% + 15px);
  overflow-y: auto;
}

.network-col2 {
  height: 130px;
  border-top: solid 0.2rem;
  border-top-color: #ffffff;
  color: white; 
  padding: 10px 15px;;
  width: calc(100% + 30px);
  margin-left: -15px;
  overflow-y: auto;
}

.f-name {
  color: white; 
  text-align: center;
  font-size: 24px;
  word-wrap: break-word;
}

.f-name1 {
  color: white; 
  padding: 0px 10px; 
  text-align: center;
  font-size: 16px;
}

.f-16 {
  font-size: 18px;
}

.m-l-20 {
  margin-left: -20px;
}

@media (min-width: 992px) {
  .network-right {
      border-left: solid 0.2rem;
      border-left-color: white;
  }
}

@media (max-width: 991px) {
  .col-md-6 {
      border-top: solid 0.2rem;
      border-color: white;
  }
}

.modal-body1 {
  height: 550px;
  width: 1100px;
  margin: 0 auto;
  float: unset;
  background: url(/images/login_bg.jpg) center no-repeat;
  background-position-x: 650px;
  background-color: #ffffff;
  background-size: cover;
  font-family: Karla;
  margin-top: 150px;
  padding: 20px 0 0 30px;
}

.landing-title {
  font-size: 36px;
  line-height: 1.2;
  padding-bottom: 10px
}

.landing-text {
  font-size: 20px;
  text-align: left;
  padding: 15px 0 5px 0px;
}

.go_sign {
  margin-top: 30px;
  padding: 7px 25px;
  font-size: 20px;
  background-color: #4cb747;
  border: none;
  color: #ffffff;
}

.go_web {
  margin-top: 30px;
  padding: 7px 25px;
  margin-left: 50px;
  font-size: 20px;
  background-color: #28ace2;
  border: none;
  color: #ffffff;
}

.link_list {
  position: absolute;
  text-align: center;
  font-size: 20px;
  bottom: 15px;
}

a+a {
  margin-left: 30px;
}

.landing-img {
  width: 90%;
  border-radius: 8px;
}

#email {
  height: 35px;
  padding-left: 5px;
}

@media screen and (max-width: 768px) {
  .modal-body1 {
      width: 360px;
      text-align: center;
  }

  .landing-title {
    font-size: 16px; 
  }

  .landing-text {
    font-size: 16px;
    text-align: center;
  }
}

.network-back {
  width: 80.5% !important;
  margin-left: 15px;
  border: solid 2px;
  border-color: #aaaaaa;
  border-radius: 4px;
}

/* Toggle Switch */
.toggle-switch {
	position: relative;
	display: inline-block;
	width: 48px;
	height: 25px;
  margin-left: 50px;
  vertical-align: middle;
}
.toggle-switch .toggle-slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #0000004d;
	-webkit-transition: .4s;
	transition: .4s;
	border-radius: 34px;
	border: 1px solid rgba(101, 103, 119, 0.21);
}
.toggle-switch .toggle-slider:before {
	position: absolute;
	content: "";
	height: 16px;
	width: 16px;
	left: 4px;
	bottom: 4px;
	background-color: #ffffff;
	-webkit-transition: .4s;
	transition: .4s;
	border-radius: 50%;
}
.toggle-switch input {
	visibility: hidden;
}
.toggle-switch input:checked + .toggle-slider {
	background-color: #f16857;
}
.toggle-switch input:checked + .toggle-slider:before {
	-webkit-transform: translateX(23px);
	-ms-transform: translateX(23px);
	transform: translateX(23px);
}
.toggle-switch.toggle-switch-primary input:checked + .toggle-slider {
	background-color: #f16857;
}
.toggle-switch.toggle-switch-secondary input:checked + .toggle-slider {
	background-color: #d9dbdc;
}
.toggle-switch.toggle-switch-success input:checked + .toggle-slider {
	background-color: #389466;
}
.toggle-switch.toggle-switch-info input:checked + .toggle-slider {
	background-color: #18879d;
}
.toggle-switch.toggle-switch-warning input:checked + .toggle-slider {
	background-color: #da8115;
}
.toggle-switch.toggle-switch-danger input:checked + .toggle-slider {
	background-color: #d24571;
}
.toggle-switch.toggle-switch-light input:checked + .toggle-slider {
	background-color: #f8f9fa;
}
.toggle-switch.toggle-switch-dark input:checked + .toggle-slider {
	background-color: #39a06e;
}
label.toggle-switch.toggle-switch-dark .off {
	font-size: 7px;
	padding-top: 10px;
	padding-left: 29px;
}
label.toggle-switch.toggle-switch-dark .on {
	font-size: 10px;
	padding-left: 40px;
}

/* Personal */
#personal-dashboard .theme-title {
  border-top: solid 0.5rem;
  border-top-color: #4db848;
  padding: 0 0 5px 10px;
  color: #8a8484;
  fa
}

#personal-dashboard .theme-item {
  color: #8a8484;
  padding: 5px 20px;
  position: relative;
}

.vp45yf {
    pointer-events: none;
    position: absolute !important;
    right: 0;
    color: #8a8484;
    top: 25px;
    margin-top: -12px;
}

.z1asCe {
    display: inline-block;
    fill: currentColor;
    height: 24px;
    line-height: 24px;
    width: 24px;
}

.FXMOpb {
    /*display: inline-block;
    fill: currentColor;
    height: 24px;
    line-height: 24px;
    width: 24px;*/
    transform: rotate(180deg);
}

.clinical-content,
.newsletter-content,
.skill-content,
.need-content {
  display: none;
  font-size: 18px;
}

.clinical-item {
  text-align: right;
  padding-right: 30px;
}

::-webkit-scrollbar {
  width: 3px;

}

::-webkit-scrollbar-track {
  background-color:#00b0f0;
  padding-top:5px;
  margin-bottom:2px;
  border-radius:20px;
}

::-webkit-scrollbar-thumb {
  background-color: #4db848;
  border-radius:20px;
}
</style>
