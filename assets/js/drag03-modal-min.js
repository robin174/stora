console.log("API URL being used:",wpData.api_url),document.addEventListener("DOMContentLoaded",(async function(){const e=document.getElementById("cardModal"),t=new bootstrap.Modal(e,{backdrop:"static"});let o=null,n=[];function r(){let e=0,t=0,o=0,n=0;document.querySelectorAll(".card").forEach((r=>{let a=parseFloat(r.querySelector(".card-cost").textContent.replace("Total Cost: $",""))||0,d=r.dataset.type;if(r.closest(".cloud-costs-column"))n+=a;else switch(d){case"Cloud":e+=a;break;case"Decentralized":t+=a;break;case"On Prem":o+=a}}));const r=e+t+o,a=n-r;document.getElementById("total-cloud-cost").textContent=`$${e.toFixed(2)}`,document.getElementById("total-decentralized-cost").textContent=`$${t.toFixed(2)}`,document.getElementById("total-onprem-cost").textContent=`$${o.toFixed(2)}`,document.getElementById("total-current-cloud-cost").textContent=`$${n.toFixed(2)}`,document.getElementById("total-new-cost").textContent=`$${r.toFixed(2)}`;const d=document.getElementById("cost-difference");d.textContent=`$${Math.abs(a).toFixed(2)}`,d.style.color=a>0?"green":"red"}function a(){let e=0;if("On Prem"===o.dataset.type){e=(parseFloat(document.getElementById("costPerServer").value)||0)*(parseInt(document.getElementById("numberOfServers").value,10)||0)}else{const t=document.getElementById("cardProvider"),n=t.options[t.selectedIndex],r=n.dataset.price?parseFloat(n.dataset.price):0,a=parseInt(document.getElementById("cardNumber").value,10)||0;e=a*r,o&&(o.querySelector(".card-text").textContent=`Number: ${a} TB`)}document.getElementById("calculatedCost").textContent=`Total Cost: $${e.toFixed(2)}`}console.log("Fetching from API URL:",wpData.api_url),document.querySelectorAll(".card").forEach((e=>{e.closest(".cloud-costs-column")||(e.setAttribute("draggable",!0),e.addEventListener("dragstart",(function(t){t.dataTransfer.setData("text/plain",e.dataset.cardId),t.dataTransfer.effectAllowed="move"})),e.addEventListener("DOMSubtreeModified",r))})),document.querySelectorAll(".row[data-row] .col[data-column]").forEach((e=>{e.addEventListener("dragover",(e=>e.preventDefault())),e.addEventListener("drop",(function(t){t.preventDefault();const o=t.dataTransfer.getData("text/plain"),n=document.querySelector(`[data-card-id="${o}"]`);if(!n)return;n.closest(".row[data-row]")===e.closest(".row[data-row]")?(e.appendChild(n),function(e,t){const o={1:"Cloud",2:"Decentralized",3:"On Prem"}[t]||"Unknown";e.dataset.type=o,"On Prem"===o?document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="block")):document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="none"))}(n,e.dataset.column),r()):console.log("Cards can only be moved left/right within the same row.")}))})),document.querySelectorAll(".btn-edit-card").forEach((e=>{e.addEventListener("click",(function(){console.log("Opening modal..."),o=this.closest(".card");const e=o.querySelector(".card-title").textContent,r=o.dataset.type;if(document.getElementById("cardTitle").value=e,"On Prem"===r){document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="block")),document.querySelectorAll(".storage-fields").forEach((e=>e.style.display="none"));const e=parseFloat(o.dataset.costPerServer)||0,t=parseInt(o.dataset.numberOfServers)||0;document.getElementById("costPerServer").value=e,document.getElementById("numberOfServers").value=t}else{document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="none")),document.querySelectorAll(".storage-fields").forEach((e=>e.style.display="block"));const e=o.dataset.cardNumber?o.dataset.cardNumber:o.querySelector(".card-text").textContent.replace("Number: ","").replace(" TB","").trim();document.getElementById("cardNumber").value=e;!function(e,t=null){const o=document.getElementById("cardProvider");o.innerHTML='<option value="0">- Please select</option>';const r=n.filter((t=>t.type===e));r.forEach((e=>{const n=document.createElement("option");n.value=e.provider,n.dataset.price=e.price,n.textContent=`${e.provider} - $${e.price} / TB`,t&&e.provider===t&&(n.selected=!0),o.appendChild(n)})),a()}(r,o.querySelector(".card-provider").textContent.replace("Provider: ","").trim())}a(),t.show()}))})),document.getElementById("cardProvider").addEventListener("change",a),document.getElementById("cardNumber").addEventListener("input",a),document.getElementById("costPerServer").addEventListener("input",a),document.getElementById("numberOfServers").addEventListener("input",a),document.getElementById("saveCardButton").addEventListener("click",(function(){if(!o)return;const e=document.getElementById("cardTitle").value,n=document.getElementById("cardProvider").value;let a=parseFloat(document.getElementById("calculatedCost").textContent.replace("Total Cost: $",""))||0;o.querySelector(".card-title").textContent=e,o.querySelector(".card-provider").textContent=`Provider: ${n}`,o.querySelector(".card-cost").textContent=`Total Cost: $${a.toFixed(2)}`,r(),t.hide()})),await async function(){try{const e=await fetch(wpData.api_url);if(!e.ok)throw new Error("Failed to fetch data from API");n=await e.json(),console.log("Fetched Airtable Data:",n)}catch(e){console.error(e.message)}}()}));