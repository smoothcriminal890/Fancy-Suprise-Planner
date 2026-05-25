
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active");
  navLinks.classList.toggle("active");
});

document.querySelectorAll(".nav-links a").forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    const target = document.querySelector(link.getAttribute("href"));
    target.scrollIntoView({ behavior: "smooth" });
    if(navLinks.classList.contains("active")) {
      navLinks.classList.remove("active");
      hamburger.classList.remove("active");
    }
  });
});

document.getElementById("commentForm")?.addEventListener("submit", e => {
  e.preventDefault();
  alert("Thank you! Message sent.");
  e.target.reset();
});
  const observer = new IntersectionObserver((entries)=>{ 
   entries.forEach((entry)=>{
   if(entry.isIntersecting){
   entry.target.classList.add('show')
   console.log(entry.target)
    }
    else{
      entry.target.classList.remove('show')
    }
  })
  },{});
  let classes = ["package-card","gallery-video","feature-card","testimonial-card"]
 const cards = document.querySelectorAll('.package-card');
  classes.forEach(el=>{
document.querySelectorAll(`.${el}`).forEach(el => observer.observe(el));
  }
  )
  document.getElementById("follow-us-section").querySelectorAll("a").forEach((el) => observer.observe(el));