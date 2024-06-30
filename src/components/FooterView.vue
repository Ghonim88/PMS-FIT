<template>
  <div>
    <footer class="footer">
      <div class="container">
        <div class="row justify-content-center">
          <h1 class="text-center w-100 text">PMS-FIT</h1>
          <div class="col">
            <h5>Products</h5>
            <p>Food</p>
            <p>Exercise</p>
            <p>Workout</p>
          </div>
          <div class="col">
            <h5>Resources</h5>
            <p>Blog</p>
            <p>Community</p>
            <p>Contact us</p>
          </div>
          <div class="col">
            <h5>Contact Information</h5>
            <p>123 Main St, Anytown, Haarlem</p>
            <p>(123) 456-7890</p>
            <p>info@pmsfit.com</p>
          </div>
          <div class="col text-right">
            <a href="https://www.facebook.com/BasicFitNederland/"><i class="fab fa-facebook"></i></a>
            <a href="https://www.youtube.com/c/BasicFitNederland"><i class="fab fa-youtube"></i></a>
            <a href="https://www.instagram.com/basicfitnl/?hl=en"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>


</script>


<style scoped>

.footer .container {
  color: white;
  background-color: rgb(0, 0, 0);
  width:100%;
  max-width: 90%;
  padding:20px;
  border: solid 2px rgb(255, 104, 4);
  border-bottom: none;
  margin-top:40px;
}
a{
  text-decoration: none ;
}
.footer .container a {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  color: white;
  margin: 0 10px;
  background-color: rgb(54, 54, 54);
  border-radius: 50%; 
  width: 50px; 
  height: 50px;
}

.footer .container .fab {
  font-size: 2em;
  color:rgb(255, 104, 4);
}

.text{
  margin-bottom: 20px;
}
</style>