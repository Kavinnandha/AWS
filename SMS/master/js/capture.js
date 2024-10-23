window.addEventListener('load', function() {
    var myModal = new bootstrap.Modal(document.getElementById('captureModal'));
    myModal.show();
});

const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const saveButton = document.getElementById('save');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing the camera: " + err);
        });

   
    saveButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        
  
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

       
        const imageDataURL = canvas.toDataURL('image/png');

        
        const downloadLink = document.createElement('a');
        downloadLink.href = imageDataURL;
        downloadLink.download = 'captured_image.png';
        downloadLink.click(); 
    });