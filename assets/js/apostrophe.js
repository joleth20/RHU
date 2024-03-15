     const inputElements = document.querySelectorAll('.form-control');

    // Attach the event listener to each input element
    inputElements.forEach(input => {
      input.addEventListener('input', function() {
        // Get the current value of the input
        let inputValue = this.value;

        // Check if the input contains an apostrophe
        if (inputValue.includes("'")) {
          // If apostrophe found, remove it from the input value
          inputValue = inputValue.replace(/'/g, '');

          // Update the input value without apostrophes
          this.value = inputValue;
        }
      });
    });