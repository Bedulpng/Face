/** @format */
//document.getElementById("wajah").innerHTML = "Silahkan Input Foto";
const request = new XMLHttpRequest();
request.open("GET", "master_action.php?read=1", false); // `false` makes the request synchronous
request.send(null);

if (request.status === 200) {
  const names = request.responseText;
  const labels = names.split(" ");
  if (labels != "") {
    const imageUpload = document.getElementById("imageUpload");
    Swal.fire({
      title: "Tunggu....",
      html: "Load Face-Api !", // add html attribute if you want or remove
      allowOutsideClick: false,
      showConfirmButton: false,
      willOpen: () => {
        Swal.showLoading();
      },
    });
    Promise.all([
      faceapi.nets.faceRecognitionNet.loadFromUri("./assets/models"),
      faceapi.nets.faceLandmark68Net.loadFromUri("./assets/models"),
      faceapi.nets.ssdMobilenetv1.loadFromUri("./assets/models"),
    ]).then(start);

    async function start() {
      const container = document.getElementById("im_preview");
      //const container = document.createElement("div");
      //container.style.position = "relative";
      //document.body.append(container);
      const labeledFaceDescriptors = await loadLabeledImages();
      const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6);
      let image;
      let canvas;
      swal.close();
      document.getElementById("tulisan_silahkan").innerHTML =
        "Silahkan Input Gambar";

      //document.body.append("Loaded");
      imageUpload.addEventListener("change", async () => {
        if (imageUpload.value !== "") {
          //Kosongkan alert
          document.getElementById("tempat_alert").innerHTML = "";
          //=======
          var filePath = imageUpload.value;

          // Allowing file type/Validasi jenis file
          var allowedExtensions = /(\.jpg)$/i;

          if (!allowedExtensions.exec(filePath)) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Tipe File " + filePath + " Invalid!",
            });

            //Sembunyikan preview kalau tipe data selain jpg
            const im_preview = document.getElementById("im_preview");
            function hidePreview() {
              im_preview.style.display = "none";
            }
            hidePreview();

            //Hapus Image
            var bersihkanClass = document.querySelectorAll(".bersihkanClass"); // HTMLCollection
            for (var i = 0; i < bersihkanClass.length; i++) {
              var classBersih = bersihkanClass[i];
              classBersih.parentNode.removeChild(classBersih);
            }
            //Hapus isi input
            imageUpload.value = "";
            //Hapus isi data
            const nama_hasil = document.getElementById("nama_hasil");
            nama_hasil.innerHTML = "";
            const tmpt_lhr_hasil = document.getElementById("tmpt_lhr_hasil");
            tmpt_lhr_hasil.innerHTML = "";
            const tgl_lhr_hasil = document.getElementById("tgl_lhr_hasil");
            tgl_lhr_hasil.innerHTML = "";
            const kelamin_hasil = document.getElementById("kelamin_hasil");
            kelamin_hasil.innerHTML = "";
            const pekerjaan_hasil = document.getElementById("pekerjaan_hasil");
            pekerjaan_hasil.innerHTML = "";
            const no_hp_hasil = document.getElementById("no_hp_hasil");
            no_hp_hasil.innerHTML = "";
            const email_hasil = document.getElementById("email_hasil");
            email_hasil.innerHTML = "";
            const alamat_hasil = document.getElementById("alamat_hasil");
            alamat_hasil.innerHTML = "";
            //Kosongkan alert
            document.getElementById("tempat_alert").innerHTML = "";
            return false;
          } else {
            //tampilkan preview
            const im_preview = document.getElementById("im_preview");
            if ((im_preview.style.display = "none")) {
              im_preview.style.display = "";
            }

            //Swal tunggu....!
            Swal.fire({
              title: "Tunggu....",
              html: "Data Dicari !", // add html attribute if you want or remove
              allowOutsideClick: false,
              showConfirmButton: false,
              willOpen: () => {
                Swal.showLoading();
              },
            });

            //Hapus Image
            var bersihkanClass = document.querySelectorAll(".bersihkanClass"); // HTMLCollection
            for (var i = 0; i < bersihkanClass.length; i++) {
              var classBersih = bersihkanClass[i];
              classBersih.parentNode.removeChild(classBersih);
            }
            //Hapus isi data
            const nama_hasil = document.getElementById("nama_hasil");
            nama_hasil.innerHTML = "";
            const tmpt_lhr_hasil = document.getElementById("tmpt_lhr_hasil");
            tmpt_lhr_hasil.innerHTML = "";
            const tgl_lhr_hasil = document.getElementById("tgl_lhr_hasil");
            tgl_lhr_hasil.innerHTML = "";
            const kelamin_hasil = document.getElementById("kelamin_hasil");
            kelamin_hasil.innerHTML = "";
            const pekerjaan_hasil = document.getElementById("pekerjaan_hasil");
            pekerjaan_hasil.innerHTML = "";
            const no_hp_hasil = document.getElementById("no_hp_hasil");
            no_hp_hasil.innerHTML = "";
            const email_hasil = document.getElementById("email_hasil");
            email_hasil.innerHTML = "";
            const alamat_hasil = document.getElementById("alamat_hasil");
            alamat_hasil.innerHTML = "";

            //Hapus isi dari div - selesai =====================
            if (image) image.remove();
            if (canvas) canvas.remove();
            image = await faceapi.bufferToImage(imageUpload.files[0]);

            //CSS disini
            //image.style.width = "500px";
            image.style.width = "100%";
            //image.style.border = "1px solid black";
            //penting.....!!!!!!!!!!!!!!!!!!!!
            container.append(image);

            canvas = faceapi.createCanvasFromMedia(image);
            //penting.....!!!!!!!!!!!!!!!!!!!!
            container.append(canvas);
            const displaySize = {
              width: image.width,
              height: image.height,
            };
            faceapi.matchDimensions(canvas, displaySize);
            const detections = await faceapi
              .detectAllFaces(image)
              .withFaceLandmarks()
              .withFaceDescriptors();

            if (detections == "") {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Wajah tidak ditemukan !",
              });
              document.getElementById("tempat_alert").innerHTML =
                "<div class='alert alert-danger text-center fw-bold'>Wajah Tidak Ditemukan !</div>";
            }

            const resizedDetections = faceapi.resizeResults(
              detections,
              displaySize
            );
            const results = resizedDetections.map((d) =>
              faceMatcher.findBestMatch(d.descriptor)
            );

            results.forEach((result, i) => {
              if (i < 1 && i == 0) {
                const box = resizedDetections[i].detection.box;
                const drawBox = new faceapi.draw.DrawBox(box, {
                  label: result.toString(),
                  boxColor: "#e60000",
                });
                drawBox.draw(canvas);

                //Ambil nomor ID --IMPORTANT--
                const no_ID_orang = result._label.toString();
                /*  document.getElementById("wajah").innerHTML =
              "No. ID : " + no_ID_orang; */

                console.log(no_ID_orang);
                if (no_ID_orang == "unknown") {
                  document.getElementById("tempat_alert").innerHTML =
                    "<div class='alert alert-danger text-center fw-bold'>Data Tidak Ditemukan !</div>";
                }

                //Ajax ambil data dari wajah
                const request = new XMLHttpRequest();
                request.open(
                  "GET",
                  `master_action.php?search_face=${no_ID_orang}`,
                  false
                ); // `false` makes the request synchronous
                request.send(null);
                //Apabila ajax sukses, ambil data
                if (request.status === 200) {
                  swal.close();
                  const dataOrangAmbil = request.responseText;
                  const dataOrang = JSON.parse(dataOrangAmbil);
                  console.log(dataOrang);
                  //Hasil Pencarian
                  //Tanggal Lahir mulai
                  //1966-06-15
                  const tgl_lengkap = dataOrang.tgl_lhr;
                  function convertDateDBtoIndo(string) {
                    bulanIndo = [
                      "",
                      "Januari",
                      "Februari",
                      "Maret",
                      "April",
                      "Mei",
                      "Juni",
                      "Juli",
                      "Agustus",
                      "September",
                      "Oktober",
                      "November",
                      "Desember",
                    ];

                    tanggal = string.split("-")[2];
                    bulan = string.split("-")[1];
                    tahun = string.split("-")[0];

                    return (
                      tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun
                    );
                  }
                  //Tanggal Lahir selesai

                  document.getElementById("nama_hasil").innerHTML =
                    dataOrang.nama;

                  document.getElementById("tmpt_lhr_hasil").innerHTML =
                    dataOrang.tmpt_lhr;
                  document.getElementById("tgl_lhr_hasil").innerHTML =
                    dataOrang.tgl_lhr;
                  document.getElementById("tgl_lhr_hasil").innerHTML =
                    convertDateDBtoIndo(tgl_lengkap);
                  document.getElementById("kelamin_hasil").innerHTML =
                    dataOrang.kelamin;
                  document.getElementById("pekerjaan_hasil").innerHTML =
                    dataOrang.pekerjaan;
                  document.getElementById("no_hp_hasil").innerHTML =
                    dataOrang.no_hp;
                  document.getElementById("email_hasil").innerHTML =
                    dataOrang.email;
                  document.getElementById("alamat_hasil").innerHTML =
                    dataOrang.alamat;

                  //gambar
                  const nama_folder = dataOrang.nomor_id;
                  const foto_orang = dataOrang.image_single;
                  //Buat tempat Image
                  let tempatFoto = document.getElementById("tempatFoto");
                  var div = document.createElement("div");
                  div.classList.add("d-flex");
                  div.classList.add("justify-content-center");
                  div.classList.add("position-relative");
                  let previewImage = new Image();
                  previewImage.classList.add("img");
                  previewImage.classList.add("bersihkanClass", "img-fluid");
                  previewImage.src =
                    "assets/labeled_images/" + nama_folder + "/" + foto_orang;
                  div.append(previewImage); // append preview image
                  tempatFoto.append(div); // append preview image
                  caches.delete(dataOrang);
                }
              } else {
                result = "";
                const box = resizedDetections[i].detection.box;
                const drawBox = new faceapi.draw.DrawBox(box, {
                  label: result.toString(),
                });
                drawBox.draw(canvas);

                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Pencarian hanya utk 1 wajah !",
                });
              }
            });

            //console.log(results)
          }
        } else {
          //Hapus Image
          var bersihkanClass = document.querySelectorAll(".bersihkanClass"); // HTMLCollection
          for (var i = 0; i < bersihkanClass.length; i++) {
            var classBersih = bersihkanClass[i];
            classBersih.parentNode.removeChild(classBersih);
          }
          //Hapus isi data
          const nama_hasil = document.getElementById("nama_hasil");
          nama_hasil.innerHTML = "";
          const tmpt_lhr_hasil = document.getElementById("tmpt_lhr_hasil");
          tmpt_lhr_hasil.innerHTML = "";
          const tgl_lhr_hasil = document.getElementById("tgl_lhr_hasil");
          tgl_lhr_hasil.innerHTML = "";
          const kelamin_hasil = document.getElementById("kelamin_hasil");
          kelamin_hasil.innerHTML = "";
          const pekerjaan_hasil = document.getElementById("pekerjaan_hasil");
          pekerjaan_hasil.innerHTML = "";
          const no_hp_hasil = document.getElementById("no_hp_hasil");
          no_hp_hasil.innerHTML = "";
          const email_hasil = document.getElementById("email_hasil");
          email_hasil.innerHTML = "";
          const alamat_hasil = document.getElementById("alamat_hasil");
          alamat_hasil.innerHTML = "";
          //Kosongkan alert
          document.getElementById("tempat_alert").innerHTML = "";
        }
      });
    }

    function loadLabeledImages() {
      //const labels = ["Donny"];
      const request = new XMLHttpRequest();
      request.open("GET", "master_action.php?read=1", false); // `false` makes the request synchronous
      request.send(null);

      if (request.status === 200) {
        const names = request.responseText;
        const labels = names.split(" ");
        //=================================
        return Promise.all(
          labels.map(async (label) => {
            const descriptions = [];
            for (let i = 1; i <= 2; i++) {
              const img = await faceapi.fetchImage(
                `assets/labeled_images/${label}/${i}.jpg`
              );
              const detections = await faceapi
                .detectSingleFace(img)
                .withFaceLandmarks()
                .withFaceDescriptor();
              descriptions.push(detections.descriptor);
            }

            return new faceapi.LabeledFaceDescriptors(label, descriptions);
          })
        );
      }
    }
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Belum ada data!",
    });
  }
}
