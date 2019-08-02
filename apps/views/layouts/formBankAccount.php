<div class="container" id="box">
    <div class="row">
        <div class="card col-sm-4" id="first">
            <div class="card-header">
                <h5 class="text-left mb-0">Desglose de su reclamacion:</h5>
            </div><!-- closing div card-header -->

            <div class="card-body" id="info">
                <p class="card-text text-left">Nombre del pasajero:</p>
                <p class="card-text text-left"><?= $name; ?></p>
                <p class="card-text text-left">Indenizacion</p>
                <p class="card-text"><?= $compensation; ?></p>
                <p class="card-text text-left">Comision Populetic</p>
                <p class="card-text"><?= $comision; ?></p>
                <p class="card-text text-left">IVA</p>
                <p class="card-text">21%</p>
                <p class="card-text text-left">Importe total a percibir</p>
                <p id="amount">
                    <?= $clientAmount; ?>€
                </p>
            </div><!-- closing div card-body -->
        </div><!-- closing card col-sm-4 -->
        <div class="card col-sm fix-width" id="second">
            <div class="card-header text-left">
                <h5 class="mb-0">Datos Bancarios:</h5>
            </div><!-- closing div card-header -->
            <div class="card-body">
                <form action="" method="POST" onsubmit="return validateForm()">
                    <div class="form-group">
                        <input class="form-control iban bank-account-number" type="text" name="account_number" placeholder="IBAN" id="iban" size="35" required>
                    </div><!-- clsoing div form-group -->

                    <div class="form-row">
                        <div class="form-group col-md-6 my-auto">
                            <div class="form-check d-flex">
                                <input class="form-check-input chk-iban" type="checkbox" id="formCheck-1">
                                <label class="form-check-label" for="formCheck-1">
                                    No dispongo de IBAN
                                </label>
                            </div><!-- closing div form-check d-flex -->
                        </div><!-- closing div form-group col-md-6 my-auto -->
                        <div class="form-group col-md-6">
                            <input class="form-control"  style="visibility:hidden;" type="text" placeholder="Swift" maxlength="11" name="swift" id="swift" value="" size="35">
                        </div><!-- closing div form-group col-md-6  -->
                    </div><!-- closing div form-row -->

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="address" placeholder="Dirección"  required="">
                        </div><!-- closing div form-group col-md-6  -->
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="phone" placeholder="Telefono" autocomplete="off" autofocus="" inputmode="tel" required="">
                        </div><!-- closing div form-group col-md-6  -->
                    </div><!-- closing div form-row -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="titular" placeholder="Titular de la cuenta" style="height: 53px;min-height: 53px;min-width: 200px;" required="">
                        </div><!-- closing div form-group col-md-6  -->
                        <div class="form-group col-md-6">
                            <input id="email-fix-padding" class="form-control" value="<?= $email; ?>" type="text" name="email" placeholder="Email" style="height: 53px;min-height: 53px;min-width: 200px;" autocomplete="off" autofocus="" inputmode="email" required="">
                            <i class="icon ion-ios-email-outline d-xl-flex justify-content-xl-start"></i>
                        </div><!-- closing div form-group col-md-6  -->
                    </div><!-- closing div form-row -->

                    <!--<div class="form-group">
                        <p class="text-left color-green">
                            <i class="icon ion-ios-information-outline"></i>  
                            Si has recibido más de un email de este tipo, debes poner los datos bancarios en todos los emails recibidos. &nbsp;
                            <br>
                        </p>
                    </div> closing div form-group -->

                    <div class="form-group">
                        <button class="btn btn-primary btn-block d-lg-flex flex-row-reverse justify-content-lg-center" id="btn-form-send"
                                type="submit">
                            ENVIAR
                        </button>
                    </div><!-- closing div form-group -->
                </form>
            </div><!-- closing div card-body -->
        </div><!-- closing div card -->
    </div><!-- closing div row -->
</div><!-- closing div container -->