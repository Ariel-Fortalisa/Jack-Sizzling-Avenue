// ACTIVE SIDEBAR
const allSideMenu = document.querySelectorAll('#sidebar .side-menu li .main-btn');
const submenuItems = document.querySelectorAll('#sidebar .side-menu .submenu .dropdown a');

// Function to handle main menu item clicks
allSideMenu.forEach(item => {
    item.addEventListener('click', function (e) {
        // Remove the active class from all main menu items

        
        allSideMenu.forEach(i => {
            i.classList.remove('active');
        });

        if(item.parentElement.classList.contains('active')){          
          // Add the active class to the clicked item
          const dropdown = this.parentElement.parentElement.querySelector('.dropdown');
          dropdown.classList.remove('active');
          if(document.querySelectorAll('#sidebar .side-menu li').classList.contains('active').length > 1){
            setTimeout(() => {
              this.parentElement.classList.remove('active');
            }, 400)
          }
          

        }
        else{
          // Add the active class to the clicked item
          this.parentElement.classList.add('active');
          const dropdown = this.parentElement.parentElement.querySelector('.dropdown');
          dropdown.classList.add('active');

        }
        
    });
});


// Function to handle submenu toggle
submenuItems.forEach(item => {
  item.addEventListener('click', function (e) {
      //e.preventDefault(); // Prevent default anchor behavior
      
      // Toggle the 'active' class for the parent <li> of the submenu
      const dropdown = item.parentElement.parentElement;
      dropdown.classList.remove('active');

  });
});




// ACTIVE CATEGORY BTN
  const buttons = document.querySelectorAll('.category-buttons button');

  buttons.forEach(button => {
    button.addEventListener('click', function() {
      // Remove the 'active' class from all buttons
      buttons.forEach(btn => btn.classList.remove('active'));

      // Add the 'active' class to the clicked button
      this.classList.add('active');
    });
  });


// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .uil.uil-bars');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})


// increase/decrease button
let counter = 1;

function increment() {
  counter++;
}

function decrement() {
  counter--;
}

function get() {
  return counter;
}

const inc = document.getElementById("increment");
const input = document.getElementById("input");
const dec = document.getElementById("decrement");

inc.addEventListener("click", () => {
  increment();
  input.value = get();
});

dec.addEventListener("click", () => {
  if (input.value > 1) {
    decrement();
  }
  input.value = get();
});
  


function modalShow(id){
  //hide other modals
  const otherModal = document.getElementsByClassName('modal');
  Array.from(otherModal).forEach(modal => modal.close());


  const modal = document.getElementById(id);
  modal.showModal();
}


function modalHide(id){
  const modal = document.getElementById(id);
  modal.close();
}


// select box
  // sizes
  const optionMenu = document.querySelector("#sizes"),
  selectBtn = optionMenu.querySelector("#size-btn"),
  options = optionMenu.querySelectorAll("#size-option"),
  size_text = optionMenu.querySelector("#size-text");
  selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));       
  options.forEach(option =>{
  option.addEventListener("click", ()=>{
  let selectedOption = option.querySelector("#size-op").innerText;
  size_text.innerText = selectedOption;
  optionMenu.classList.remove("active");
  });
});

  // add-ons
  const optionMenu2 = document.querySelector("#add-ons"),
  selectBtn2 = optionMenu2.querySelector("#add-on-btn"),
  options2 = optionMenu2.querySelectorAll("#add-on-option"),
  addon_text = optionMenu2.querySelector("#add-on-text");
  selectBtn2.addEventListener("click", () => optionMenu2.classList.toggle("active"));       
  options2.forEach(option =>{
  option.addEventListener("click", ()=>{
  let selectedOption2 = option.querySelector("#addon-op").innerText;
  addon_text.innerText = selectedOption2;
  optionMenu2.classList.remove("active");
});
});

  // discount
  const optionMenu3 = document.querySelector("#discount"),
  selectBtn3 = optionMenu3.querySelector("#discount-btn"),
  options3 = optionMenu3.querySelectorAll("#discount-option"),
  discount_text = optionMenu3.querySelector("#discount-text");
  selectBtn3.addEventListener("click", () => optionMenu3.classList.toggle("active"));       
  options3.forEach(option =>{
  option.addEventListener("click", ()=>{
  let selectedOption3 = option.querySelector("#discount-op").innerText;
  discount_text.innerText = selectedOption3;
  optionMenu3.classList.remove("active");
});
});

// select box

//pagination
function paginate(elem, totalPages, currentPage, tableFunction){
  if(totalPages <= 1){
      elem.html('');
      return
  }
  
  let firstPage = 1;
  let lastPage = totalPages;

  if(totalPages > 5){
      if(currentPage <= 3){
          firstPage = 1;
          lastPage = 5;
      }
      else if(currentPage >= totalPages - 3){
          firstPage = totalPages - 4;
          lastPage = totalPages;
      }
      else{
          firstPage = currentPage - 2;
          lastPage = currentPage + 2;
      }
  }
  

  elem.html('');
  let paginationButtons = '';
  for(let i = firstPage; i <= lastPage; i++){
      let generateTableFunction = 
          tableFunction +     //function name
          `(${i})`;   //paremeters of the function (ex. page number)


      let active = i == currentPage;
      

      paginationButtons += `
          <li> 
              <a role="button" href="#" class="${active && 'active'}" onclick="${generateTableFunction}">
                  ${i}
              </a>
          </li>
      `;
  }
  elem.html(`
      <div class="pagination">
          <ul class="pagination--link">
              
              <li> 
                  <a role="button" href="#" class="prev" onclick="${currentPage == 1 ? 'return false;' : `${tableFunction}(${currentPage - 1})`}" > 
                      <i class="uil uil-angle-left-b" aria-hidden="true"></i>
                  </a>
              </li>


              ${paginationButtons}

              
              <li> 
                  <a role="button" href="#" class="next" onclick="${currentPage == totalPages ? 'return false;' : `${tableFunction}(${currentPage + 1})`}" >
                      <i class="uil uil-angle-right-b" aria-hidden="true"></i>
                  </a>
              </li>
              
          </ul>
      </div>
  `);
  // elem.attr('tabindex', 0);
  // elem.css('outline', 'none');
  // elem.focus();
}