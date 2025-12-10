// assets/script.js - Beginner JS: Form validation + quiz scoring

// Function 1: Validate forms (simple check)
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let valid = true;
    inputs.forEach(input => {
        if (!input.value.trim()) {
            valid = false;
            input.style.borderColor = 'red';  // Red border on error
        } else {
            input.style.borderColor = '#ccc';
        }
    });
    return valid;
}

// Function 2: Quiz scoring (on submit)
function calculateScore() {
    const form = document.getElementById('quizForm');
    const answers = form.querySelectorAll('input[name="answer"]:checked');
    let score = 0;
    let total = answers.length;  // Assume all answered

    // Simple: Check against correct answers (you can hardcode or from data attr)
    answers.forEach(answer => {
        // Example: Assume data-correct="4" on correct option
        if (answer.dataset.correct === answer.value) {
            score++;
        }
    });

    // Show result
    const resultDiv = document.getElementById('quizResult');
    resultDiv.innerHTML = `<p class="success">Your Score: ${score}/${total}</p>`;
    resultDiv.style.display = 'block';

    // Send to PHP via form submit (hidden)
    document.getElementById('hiddenScore').value = score;
    document.getElementById('hiddenTotal').value = total;
    return true;  // Allow submit
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form.id)) {
                e.preventDefault();  // Stop if invalid
                alert('Please fill all fields!');  // Simple alert
            }
        });
    });
});