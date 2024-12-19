// Menambahkan gambar ke galeri portofolio setelah upload
document.addEventListener('DOMContentLoaded', function() {
    fetchPortfolio();
  });
  
  function fetchPortfolio() {
    fetch('fetch_photos.php')
      .then(response => response.json())
      .then(data => {
        const portfolioGallery = document.getElementById('portfolioGallery');
        portfolioGallery.innerHTML = ''; // Reset galeri
        data.forEach(photo => {
          const photoDiv = document.createElement('div');
          photoDiv.classList.add('photo');
          photoDiv.innerHTML = `
            <img src="images/${photo.image}" alt="${photo.username}">
            <h4>${photo.username}</h4>
          `;
          portfolioGallery.appendChild(photoDiv);
        });
      });
  }
  