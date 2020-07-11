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
  padding: 4rem 0rem;
}

.network-img1 {
  width: 130px; 
  text-align: center; 
  border-radius: 50%;
  border: solid .2rem;
  border-color: #ffffff;
}

.network-col1 {
  height: 150px;
  color: white; 
  padding: 10px 10px; 
}

.network-col2 {
  height: 130px;
  border-top: solid 0.2rem;
  border-top-color: #ffffff;
  color: white; 
  padding: 10px 25px;
  width: calc(100% + 30px);
  margin-left: -15px;
}

.f-name {
  color: white; 
  padding: 0px 10px; 
  text-align: center;
  font-size: 24px;
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

.landing {
  height: 600px;
  width: 800px;
  margin: 0 auto;
  float: unset;
  background: url(/images/landing.jpg) center no-repeat;
  background-size: cover;
  font-family: Karla;
}

.collect_email {
  margin-left: 70px;
  margin-top: 10px;
  padding: 10px 30px;
  font-size: 20px;
  background-color: #4cb747;
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

/*.link_list a {
  color: #4cb747;
}*/


</style>
