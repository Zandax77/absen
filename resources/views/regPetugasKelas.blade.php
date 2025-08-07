<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  </head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                  <img src="{{asset('images/logo_smk6.png')}}" width="150" height="150">
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Buat Akun Petugas Absensi Kelas</h5>
                    <p class="text-center small">Masukkan nama, sandi dan dari kelas mana</p>
                  </div>

                  <form class="row g-3 needs-validation" action="simpanPetugasKelas" method="POST">
                    @csrf
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nama Lengkap :</label>
                      <input type="text" name="nama" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">silahkan masukkan nama!</div>
                    </div>

                    <div class="col-12">
                      <label for="kelas" class="form-label">Kelas</label>
                      <select name="kelas" id="" required class="form-control">
                        <option value=""></option>
                        @foreach ($kelas as $isi)
                            <option value="{{$isi['kelas']}}">{{$isi['kelas']}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Kode operator</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="kode" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">silahkan masukkan kode petugas</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Sandi</label>
                      <input type="password" name="sandi" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">silahkan masukkan sandi</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Sudah mempunyai akun? <a href="loginKelas">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Pendaftaran akun petugas absen kelas
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
