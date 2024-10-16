var count = document.querySelectorAll('.count');
//console.log(count);
var inc = [];

var countsID = document.getElementById("countsID");
window.onscroll = function (){
  var topElem = countsID?.offsetTop;
  var btmElem = countsID?.offsetTop + countsID?.clientHeight;
  var topScreen = window.pageYOffset;
  var btmScreen = window.pageYOffset + window.innerHeight;
  if(btmScreen > topElem && topScreen < btmElem){
    counterFunc();
  }
}
function counterFunc(){
  for(let i=0; i<count.length; i++){
    inc.push(0);
    let interval = setInterval(() =>{
      if(inc[i] <= count[i].getAttribute("data-purecounter-end")){
        inc[i]++;
        count[i].innerHTML = inc[i];
      }
      else{
        clearInterval(interval);
      }
    }, 1500);
  }
}

/*
let nums = document.querySelectorAll(".count-box .count");
let section = document.querySelector(".counts");
let started = false;

window.onscroll = function (){
  if(window.scrollY >= section.offestTop){
    if(!started){
      nums.forEach((count) => startCount(count));
    } 
      started = true;
  }
}
function startCount(el){
  let goal = el.dataset.goal;
  let count = setInterval(() => {
    el.textContent++;
    if(el.textContent == goal){
      clearInterval(count);
    }
  }, 1000 / goal);
}
*/
