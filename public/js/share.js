
const shareBtn = document.getElementById("share");
const report = document.getElementById("content");

let imgData;

function downloadReport(img) {
    const a = document.createElement('a');
    a.href = img;
    a.download = 'report.png'
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.remove.appendChild(a);
}

shareBtn.addEventListener('click', () => {
    html2canvas(report).then(canvas => {
        imgData = canvas.toDataURL('image/png');
        downloadReport(imgData);
    })
})