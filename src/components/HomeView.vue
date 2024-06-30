<template>
  <div>
    <div class="background-image">
      <div class="intro-container container">
        <div class="intro-text">
          <h1 class="title">Welcome to the PMS FIT</h1>
          <h2 class="text">
            Step into a world of transformation, where your fitness aspirations take center stage.
            we believe that every journey begins with a single step, and we're thrilled to be your
            companion on the path to a healthier, stronger, and more vibrant you
          </h2>
        </div>
      </div>
    </div>

    <div class="container features-container">
      <!-- The rest of your HTML goes here -->
      <div class="row mb-5 mt-5">
        <div class="col-md-6 mb-2">
          <div>
            <img class="img-fluid" src="/img/home/image1.jpg" alt="Feature 1" />
          </div>
        </div>

        <div class="col-md-6">
          <div>
            <h2 class="content fa-text-orange mb-2">Personalized Workouts</h2>
            <p>
              Unlock a fitness experience tailored just for you. Our expertly crafted workouts are
              designed to elevate your strength, endurance, and overall well-being. Whether you're
              aiming for weight loss, muscle gain, or improved flexibility, we have a plan that fits
              your goals. Our team of fitness professionals has carefully curated a variety of
              exercises to keep your workouts dynamic and engaging. From heart-pumping cardio
              sessions to targeted strength training, each routine is a step towards realizing your
              full potential.
            </p>
          </div>
        </div>
      </div>

      <div class="row mb-5">
        <div class="col-md-6 order-md-2 mb-2">
          <div>
            <img class="img-fluid" src="/img/home/image3.jpg" alt="Feature 2" />
          </div>
        </div>

        <div class="col-md-6 order-md-1">
          <div>
            <h2 class="content fa-text-orange mb-2">Nutrition Guidance</h2>
            <p>
              Elevate your fitness journey with personalized nutrition guidance that goes beyond
              counting calories. We understand that fueling your body with the right nutrients is
              essential for achieving your health goals. Our nutrition experts have crafted a
              diverse and balanced selection of foods to support your unique needs. From wholesome
              meals to energizing snacks, each recommendation is designed to nourish your body,
              enhance your performance, and contribute to your overall well-being. Say goodbye to
              restrictive diets and embrace a sustainable approach to nutrition. 
            </p>
          </div>
        </div>
      </div>

      <div class="row mb-5">
        <div class="col-md-6">
          <div>
            <img class="img-fluid" src="/img/home/image2.jpg" alt="Feature 3" />
            <h2 class="content fa-text-orange mb-2 mt-2">Community Support</h2>
            <p class="p-special">
              Join a thriving community of like-minded individuals committed to the pursuit of
              health and wellness. Our community support is more than just a space to connect—it's a
              source of inspiration, motivation, and encouragement. Share your victories, exchange
              tips, and find strength in the collective journey towards fitness excellence. Whether
              you're seeking advice, celebrating milestones, or simply sharing your story, our
              community is here to uplift and empower you. At PMS FIT, we believe in the power of
              togetherness. 
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div>
            <img class="img-fluid" src="/img/home/image5.jpg" alt="Feature 4" />
            <h2 class="content fa-text-orange mb-2 mt-2">Progress Tracking</h2>
            <p class="p-special">
              Empower your fitness journey with real-time progress tracking that transforms your
              goals into tangible achievements. Say goodbye to guesswork and embrace a data-driven
              approach to wellness. Our intuitive tracking system allows you to monitor every step
              of your journey. From the calories burned during your workouts to the fluctuations in
              your weight, witness your progress unfold before your eyes. Celebrate your victories,
              both big and small, and gain valuable insights into your fitness trends. 
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<style scoped>


.background-image {
  background-image: url('../img/home/ImageIntro.jpg');
  background-size: cover;
  background-position: center;
  min-height: 80vh;
  width: 99vw;
  display: flex;
  align-items: center;
  justify-content: center;
}

.intro-container {
  text-align: center;
  color: rgb(100, 41, 41);
}
.intro-text {
  z-index: 2;
  color: rgb(248, 244, 241);
  backdrop-filter: blur(50px);
  padding: 10px;
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 1;
  margin-top: 200px;
  width: auto;
  border-radius: 20px; 
}

.title {
  font-size: 2rem;
  font-weight: bold; 
  color:  rgb(218, 92, 8);
}

.text {
  font-size: 1.5rem; 
  font-weight: normal; 
  margin-top: 10px; 
  width: 80%; 
  margin-left: 10%; 
}
.features-container img {
  max-width: 100%;
  height: 40vh;
  width: 50vh;
  border-radius: 10px;
}
.content {
  color: rgb(255, 104, 4);
  font-size: 2rem;
  font-weight: bold;
}
p{
  font-size: 1.2rem;
  font-weight: normal;
  color: rgb(253, 253, 253);
}
.p-special{
 width: 60vh;
 align-content: center;
 align-items: center;
}
/* The rest of your CSS goes here */
</style>
