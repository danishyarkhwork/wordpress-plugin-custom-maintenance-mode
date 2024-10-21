// Countdown Timer Logic
document.addEventListener("DOMContentLoaded", function () {
  const countdownElement = document.getElementById("countdown");
  const targetTime = cmm_data.countdown_time; // Retrieve PHP data passed via wp_localize_script

  if (targetTime && countdownElement) {
    const updateCountdown = function () {
      const now = new Date().getTime();
      const timeLeft = targetTime - now;

      const hours = Math.floor(timeLeft / (1000 * 60 * 60));
      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

      countdownElement.innerHTML = `${hours}h ${minutes}m ${seconds}s`;

      if (timeLeft < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "We are live now!";
      }
    };

    const countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown();
  }
});
