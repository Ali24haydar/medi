document.addEventListener("DOMContentLoaded",function(){
    let date = document.getElementById('date');
    let currentDate = new Date();
    let options = { year: 'numeric', month: 'short', day: 'numeric' };
    let formattedDate = currentDate.toLocaleDateString('en-US',options);
    formattedDate = formattedDate.replace(/,/g, '');
    date.textContent = formattedDate;
})