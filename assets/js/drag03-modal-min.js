console.log("API URL being used:",wpData.api_url),document.addEventListener("DOMContentLoaded",(async function(){const e=document.getElementById("cardModal"),t=new bootstrap.Modal(e,{backdrop:"static"});let r=null,o=[];function n(){let e=0,t=0,r=0,o=0;document.querySelectorAll(".card").forEach((n=>{let a=parseFloat(n.querySelector(".card-cost").textContent.replace("Total Cost: $",""))||0,d=n.dataset.type;if(n.closest(".cloud-costs-column"))o+=a;else switch(d){case"Cloud":e+=a;break;case"Decentralized":t+=a;break;case"On Prem":r+=a}}));const n=e+t+r,a=o-n;document.getElementById("total-cloud-cost").textContent=`$${e.toFixed(2)}`,document.getElementById("total-decentralized-cost").textContent=`$${t.toFixed(2)}`,document.getElementById("total-onprem-cost").textContent=`$${r.toFixed(2)}`,document.getElementById("total-current-cloud-cost").textContent=`$${o.toFixed(2)}`,document.getElementById("total-new-cost").textContent=`$${n.toFixed(2)}`;const d=document.getElementById("cost-difference");d.textContent=`$${Math.abs(a).toFixed(2)}`,d.style.color=a>0?"green":"red"}function a(){let e=0;if("On Prem"===r.dataset.type){const t=parseFloat(document.getElementById("costPerServer").value)||0,o=parseInt(document.getElementById("numberOfServers").value,10)||0;e=t*o,r&&(r.querySelector(".card-text").textContent=`Number of Servers: ${o} @ $${t}/server`)}else{const t=document.getElementById("cardProvider"),o=t.options[t.selectedIndex],n=o.dataset.price?parseFloat(o.dataset.price):0,a=parseInt(document.getElementById("cardNumber").value,10)||0;e=a*n,r&&(r.querySelector(".card-text").textContent=`Number: ${a} TB`)}document.getElementById("calculatedCost").textContent=`Total Cost: $${e.toFixed(2)}`}console.log("Fetching from API URL:",wpData.api_url),document.querySelectorAll(".card").forEach((e=>{e.closest(".cloud-costs-column")||(e.setAttribute("draggable",!0),e.addEventListener("dragstart",(function(t){t.dataTransfer.setData("text/plain",e.dataset.cardId),t.dataTransfer.effectAllowed="move"})),e.addEventListener("DOMSubtreeModified",n))})),document.querySelectorAll(".row[data-row] .col[data-column]").forEach((e=>{e.addEventListener("dragover",(e=>e.preventDefault())),e.addEventListener("drop",(function(t){t.preventDefault();const r=t.dataTransfer.getData("text/plain"),o=document.querySelector(`[data-card-id="${r}"]`);if(!o)return;o.closest(".row[data-row]")===e.closest(".row[data-row]")?(e.appendChild(o),function(e,t){const r={1:"Cloud",2:"Decentralized",3:"On Prem"}[t]||"Unknown";e.dataset.type=r,"On Prem"===r?document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="block")):document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="none"))}(o,e.dataset.column),n()):console.log("Cards can only be moved left/right within the same row.")}))})),document.querySelectorAll(".btn-edit-card").forEach((e=>{e.addEventListener("click",(function(){console.log("Opening modal..."),r=this.closest(".card");const e=r.querySelector(".card-title").textContent,n=r.dataset.type;if(document.getElementById("cardTitle").value=e,"On Prem"===n){document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="block")),document.querySelectorAll(".storage-fields").forEach((e=>e.style.display="none"));const e=r.dataset.costPerServer?parseFloat(r.dataset.costPerServer):0,t=r.dataset.numberOfServers?parseInt(r.dataset.numberOfServers,10):0;document.getElementById("costPerServer").value=e,document.getElementById("numberOfServers").value=t}else{document.querySelectorAll(".onprem-fields").forEach((e=>e.style.display="none")),document.querySelectorAll(".storage-fields").forEach((e=>e.style.display="block"));const e=r.dataset.cardNumber?r.dataset.cardNumber:r.querySelector(".card-text").textContent.replace("Number: ","").replace(" TB","").trim();document.getElementById("cardNumber").value=e;!function(e,t=null){const r=document.getElementById("cardProvider");r.innerHTML='<option value="0">- Please select</option>';const n=o.filter((t=>t.type===e));n.forEach((e=>{const o=document.createElement("option");o.value=e.provider,o.dataset.price=e.price,o.textContent=`${e.provider} - $${e.price} / TB`,t&&e.provider===t&&(o.selected=!0),r.appendChild(o)})),a()}(n,r.querySelector(".card-provider").textContent.replace("Provider: ","").trim())}a(),t.show()}))})),document.getElementById("cardProvider").addEventListener("change",a),document.getElementById("cardNumber").addEventListener("input",a),document.getElementById("costPerServer").addEventListener("input",a),document.getElementById("numberOfServers").addEventListener("input",a),document.getElementById("saveCardButton").addEventListener("click",(function(){if(!r)return;const e=document.getElementById("cardTitle").value;let o=parseFloat(document.getElementById("calculatedCost").textContent.replace("Total Cost: $",""))||0;if("On Prem"===r.dataset.type){const e=parseFloat(document.getElementById("costPerServer").value)||0,t=parseInt(document.getElementById("numberOfServers").value,10)||0;r.dataset.costPerServer=e,r.dataset.numberOfServers=t,r.querySelector(".card-text").textContent=`Number of Servers: ${t} @ $${e}/server`}else{const e=document.getElementById("cardNumber").value;r.dataset.cardNumber=e,r.querySelector(".card-text").textContent=`Number: ${e} TB`;const t=document.getElementById("cardProvider").value;r.querySelector(".card-provider").textContent=`Provider: ${t}`}r.querySelector(".card-title").textContent=e,r.querySelector(".card-cost").textContent=`Total Cost: $${o.toFixed(2)}`,n(),t.hide()})),await async function(){try{const e=await fetch(wpData.api_url);if(!e.ok)throw new Error("Failed to fetch data from API");o=await e.json(),console.log("Fetched Airtable Data:",o)}catch(e){console.error(e.message)}}()}));