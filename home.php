<?php
session_start();

// Optional: Protect page from unauthenticated users
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION["username"]); // Sanitize output
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Health Awareness Portal</title>
  <style>
    body {
      background-image: linear-gradient(to right, #4A90E2, #34C759, #FFD60A);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f5f5;
      color: #333;
    }
    a{
        text-decoration:none;
    }
    header {
      background: #0077cc;
      color: white;
      padding: 2rem;
      text-align: center;
      border-bottom: 4px solid #004f8c;
    }
    header h1 {
      font-size: 2.5rem;
      margin: 0;
    }
    .container {
      padding: 2rem;
    }
    .card {
      background: white;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #0077cc;
    }

    /* Myth vs Fact scrollable styling */
    .scroll-container {
      display: flex;
      overflow-x: auto;
      gap: 1rem;
      padding-bottom: 1rem;
      scroll-snap-type: x mandatory;
      scroll-behavior: smooth;
    }
    .scroll-container::-webkit-scrollbar {
      height: 10px;
    }
    .scroll-container::-webkit-scrollbar-track {
      background: #e0e0e0;
      border-radius: 10px;
    }
    .scroll-container::-webkit-scrollbar-thumb {
      background: linear-gradient(to right, #0077cc, #00c6ff);
      border-radius: 10px;
      border: 2px solid #f5f5f5;
    }
    .scroll-container::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(to right, #005fa3, #00aaff);
    }

    .myth-fact {
      min-width: 320px;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      scroll-snap-align: start;
      background: #eef6fb;
      padding: 1rem;
      border-radius: 8px;
      font-size: 1.1rem;
    }

    .education-section ul,
    .card ul {
      list-style: none;
      padding-left: 0;
    }
    .education-section li,
    .card li {
      margin-bottom: 1rem;
      padding-left: 1.5rem;
      position: relative;
    }
    .education-section li:before,
    .card li:before {
      content: '✔';
      position: absolute;
      left: 0;
      color: #0077cc;
      font-size: 1.5rem;
      top: 50%;
      transform: translateY(-50%);
    }
    .quiz .question {
      margin-bottom: 1.5rem;
      padding: 1rem;
      background: #f1f1f1;
      border-radius: 8px;
    }
    .quiz button,
    .card button,.back {
      background: #0077cc;
      color: white;
      border: none;
      padding: 1rem 2rem;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .quiz button:hover,
    .card button:hover ,.back:hover{
      background: #004f8c;
    }
    footer {
      background: #0077cc;
      color: white;
      text-align: center;
      padding: 1rem;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
  <header>
    <img src="logo.jpg" alt="logo" style="height: 60px; width: 60px; margin-left: 10px; border-radius: 50%">
    <h1>Health Awareness Portal</h1>
    <a href="#Dc">Doctor Consultation|</a>
    <a href="#Em">Emergency 24/7|</a>
    <a href="#quiz">Quiz|</a>
    <a href="login.php">Logout</a>
  </header>
  <h2>Hello, <?php echo $username; ?>!</h2>
  <h3>Recommended:</h3><br>
  <div class="container">
    <!-- Health Tip -->
    <div class="card">
      <h3>Daily Health Tip</h3>
      <p>Wash your hands before meals to prevent infections.</p>
    </div>

    <!-- Myth vs Fact (Auto-Scrolling) -->
    <div class="card">
      <h3>Myth vs Fact</h3>
      <div class="scroll-container" id="mythFactScroll">
  <div class="myth-fact">
    <div><strong>Myth:</strong> Cold weather causes pneumonia.</div>
    <div><strong>Fact:</strong> Pneumonia is caused by viruses or bacteria, not cold air.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Vaccines cause autism.</div>
    <div><strong>Fact:</strong> Research shows no link between vaccines and autism.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Only old people get heart disease.</div>
    <div><strong>Fact:</strong> Heart disease can affect all ages, especially with poor habits.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> You only need sunscreen on sunny days.</div>
    <div><strong>Fact:</strong> UV rays can harm skin even on cloudy days.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Drinking lots of water detoxifies everything.</div>
    <div><strong>Fact:</strong> Your liver and kidneys handle detox naturally.</div>
  </div>
  <!-- New Myths and Facts -->
  <div class="myth-fact">
    <div><strong>Myth:</strong> Eating carrots improves your eyesight.</div>
    <div><strong>Fact:</strong> While carrots are rich in vitamin A, they do not directly improve eyesight. A balanced diet is necessary for good eye health.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> You should drink eight glasses of water a day.</div>
    <div><strong>Fact:</strong> The amount of water you need depends on factors like age, activity level, and climate. Hydration is about listening to your body’s needs.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Sugar makes kids hyperactive.</div>
    <div><strong>Fact:</strong> Studies have shown that sugar does not cause hyperactivity in children. The behavior is more likely due to the excitement of events where sugary foods are present.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> You can catch a cold by getting wet in the rain.</div>
    <div><strong>Fact:</strong> Colds are caused by viruses, not rain. However, getting chilled can weaken your immune system, making you more susceptible to infections.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Cracking your knuckles causes arthritis.</div>
    <div><strong>Fact:</strong> Cracking your knuckles may annoy others, but it doesn't lead to arthritis. It does cause the release of gases from the joints, creating the popping sound.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Eating at night makes you gain weight.</div>
    <div><strong>Fact:</strong> It's not about when you eat, but rather what and how much you eat. Eating high-calorie foods late at night can contribute to weight gain if it leads to an overall calorie surplus.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> If you don’t feel thirsty, you don’t need water.</div>
    <div><strong>Fact:</strong> Thirst is not always a reliable indicator of hydration. Even if you’re not thirsty, it's essential to drink enough water to keep your body hydrated.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Natural or organic products are always better for you.</div>
    <div><strong>Fact:</strong> Just because something is natural or organic doesn't necessarily mean it’s safer or more effective. It's essential to evaluate products based on their specific properties and quality.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> Men and women should eat the same number of calories.</div>
    <div><strong>Fact:</strong> Caloric needs vary based on age, activity level, and other factors, so men and women typically have different caloric requirements.</div>
  </div>
  <div class="myth-fact">
    <div><strong>Myth:</strong> If you sweat a lot during exercise, you’re burning more fat.</div>
    <div><strong>Fact:</strong> Sweat is your body's way of cooling down and has nothing to do with fat loss. Fat is burned through consistent physical activity and maintaining a healthy diet.</div>
  </div>
</div>


    <!-- Health Education -->
    <div class="card education-section">
      <h3>Health Education Topics</h3>
      <ul>
        <li>Nutrition and hydration tips</li>
        <li>Benefits of regular exercise</li>
        <li>Personal and oral hygiene</li>
        <li>Child and maternal care</li>
        <li>Vaccination schedules</li>
        <li>Mental wellness practices</li>
        <li>Managing chronic diseases</li>
      </ul>
    </div>

    <!-- Health Quiz -->
    <div class="card quiz" id ="quiz">
      <h3>Health Quiz</h3>
      <div class="question">
        <p>How many hours of sleep are recommended for adults?</p>
        <p><strong>Answer:</strong> 7–9 hours</p>
      </div>
      <div class="question">
        <p>Which vitamin do you get from sunlight?</p>
        <p><strong>Answer:</strong> Vitamin D</p>
      </div>
      <button>Take Full Quiz</button>
    </div>

    <!-- Doctor Consultation -->
    <div class="card" id="Dc">
      <h3>Doctor Consultation</h3>
      <p>Need to speak with a doctor? Book a virtual or in-person consultation easily.</p>
      <ul>
        <li>24/7 General Physician Access</li>
        <li>Specialist Appointments</li>
        <li>Telemedicine Support</li>
        <li>Free follow-ups for 7 days</li>
      </ul>
      <button><a href="doctor.html">Book Consultation</a></button>
    </div>

    <!-- Emergency Services -->
    <div class="card" id='Em'>
      <h3>Emergency Services</h3>
      <p>Quick help during emergencies is critical. Access help here.</p>
      <ul>
        <li>Ambulance Service (Dial 108)</li>
        <li>First Aid Guidelines</li>
        <li>Nearest Hospital Locator</li>
        <li>Direct Emergency Call</li>
      </ul>
      <button onclick="alert('Calling Emergency...')">Call Emergency</button>
    </div>
  </div>
<button class="back"><a href="#" style="color:white;">Back to top</a></button>
  <footer>
    <p>&copy; 2025 Health Awareness Portal | All Rights Reserved</p>
    
  </footer>

  <!-- Auto-scroll script -->
  <script>
    const scrollContainer = document.getElementById('mythFactScroll');
    let scrollAmount = 0;
    const scrollStep = 340;
    const delay = 3000;

    setInterval(() => {
      if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth) {
        scrollContainer.scrollTo({ left: 0, behavior: 'smooth' });
        scrollAmount = 0;
      } else {
        scrollAmount += scrollStep;
        scrollContainer.scrollTo({ left: scrollAmount, behavior: 'smooth' });
      }
    }, delay);
  </script>
</body>
</html>
