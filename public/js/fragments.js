const fragments = {
  formOptions:
  `<h3>Alterar dados</h3>
  <div class="h100 w100 flex-start">
    <div class="flex-column row overflow-hidden" style="max-height: 95px;">
      <label class="txt-shadow">Nome:</label>
      <span class="txt-shadow">{!name!}</span>
      <button data-edit="name" class="btn input txt-shadow gradient radius"><i class="fas fa-user-edit"></i>
      Editar</button>
    </div>
    <div class="flex-column row overflow-hidden " style="max-height: 95px;">
      <label class="txt-shadow">Email:</label>
      <span class="txt-shadow">{!email!}</span>
      <button data-edit="email" class="btn input txt-shadow gradient radius"><i class="fas fa-user-edit"></i>Editar</button>
    </div>
    <div class="flex-column row overflow-hidden " style="max-height: 95px;">
      <label class="txt-shadow">Senha:</label>
      <span class="txt-shadow">• • • • • • • •</span>
      <button data-edit="password" class="btn input txt-shadow gradient radius"><i class="fas fa-user-edit"></i>Editar</button>
    </div>
  </div>`,
  formUpdate: 
  `<div class="w100 h100 flex-center-column">
    <label>{!label!}</label>
    <input data-js="get" data-type="{!data-type!}" class="link-input input radius" type="{!type!}" placeholder="{!placeholder!}" required/>
    <input data-btn="update" class="btn input gradient radius" type="submit" value="Alterar dados" />
    <button class="link-nav" style="background:transparent;border:none;font-weight:bold;cursor:pointer" data-btn="back">VOLTAR <-</button>
   </div>`,
  modal:
  `<div class="modal flex-center">
    <div class="container">
      <div class="flex-between">
        <h3>Editar link</h3>
        <i id="close" class="far fa-times-circle txt-shadow"></i>
      </div>
      <div>
        <div class="flex-column">
          <div style="margin-top: 25px;" class="overflow-hidden w50">
            <span style="font-weight:bold" class="txt-shadow">Redirecionamento atual:</span>
            <h3><a target="_blank" href="{{link.redirect}}" class="main-green txt-shadow">{{link.redirect}}</a></h3>
          </div>
          <div style="margin-top: 25px;" class="overflow-hidden w50">
            <span style="font-weight:bold" class="txt-shadow">Código do link:</span>
            <h3><a target="_blank" href="{{link.shorted}}" class="main-green txt-shadow">{{link.id}}</a></h3>
          </div>
        </div>
        <div id="main-content" class="w100 flex-center-column" style="margin-top: 30px;">
          <input id="redirect" class="link-input input radius" type="text" placeholder="Digite o novo link de destino" required />
          <input id="submit" class="btn input gradient txt-shadow radius" type="submit" value="Concluir" />
        </div>
      </div>
    </div>
  </div>`,
  modalDelete:
  `<div class="modal flex-center">
      <div class="container">
        <div class="flex-between">
          <h3>Deletar link</h3>
          <i id="close" class="far fa-times-circle txt-shadow"></i>
        </div>
        <div>
          <div class="flex-column">
            <div style="margin-top: 25px;" class="overflow-hidden w50">
              <span style="font-weight:bold" class="txt-shadow">Redirecionamento atual:</span>
              <h3><a target="_blank" href="{{link.redirect}}" class="main-green txt-shadow">{{link.redirect}}</a></h3>
            </div>
            <div style="margin-top: 25px;" class="overflow-hidden w50">
              <span style="font-weight:bold" class="txt-shadow">Código do link:</span>
              <h3><a target="_blank" href="{{link.shorted}}" class="main-green txt-shadow">{{link.id}}</a></h3>
            </div>
            <div style="margin-top: 25px;" class="overflow-hidden w50">
              <span style="font-weight:bold" class="txt-shadow">Total de cliques:</span>
              <h3 class="main-green txt-shadow">{{link.click_count}}</h3>
            </div>
          </div>
          <div id="main-content" class="w100 flex-center-column" style="margin-top: 30px;">
            <input id="submit" class="btn input red-gradient txt-shadow radius" type="submit" value="Confirmar exclusão" />
          </div>
        </div>
      </div>
    </div>`,
    clickModal: `
    <div class="modal flex-center">
      <div class="w100 flex-center" style="height: 90%;">
        <div class="container w100 h100">
          <div class="flex-between">
            <h3>Informações do click</h3>
            <i id="close" class="far fa-times-circle txt-shadow"></i>
          </div>
          <div class="h100 w100 scroll" style="overflow-y: scroll;">
            <div class="flex-column w100">
              <div style="margin-top: 25px;" class="overflow-hidden w100 flex-column  ">
                <h3 style="font-weight:bold" class="txt-shadow">Resumo:</h3>
                <div class="row">
                  <span class="txt-shadow">Alguém clicou no seu link as {!hour!} do dia {!date!}. O IP de quem clicou é {!ip!} e sua possivel localização se encontra em {!country!}, {!city!}, {!zip!} nas coordenadas Longitude: {!long!} e Latitude: {!lat!}</span>
                </div>
              </div>
              <div style="margin-top: 25px;" class="overflow-hidden w100 flex-column  ">
                <h3 style="font-weight:bold" class="txt-shadow">Dados capturados:</h3>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">IP:</label>
                  <span>{!ip!}</span>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">Versão IP:</label>
                  <span>{!ip_version!}</span>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">Data:</label>
                  <span>{!date!}</span>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">Horario:</label>
                  <span>{!hour!}</span>
                </div>
              </div>
              <div style="margin-top: 25px;" class="overflow-hidden w100 flex-column  ">
                <h3 style="font-weight:bold" class="txt-shadow">Localização:</h3>
                <div class="warning flex-evenly">
                  <i class="fas fa-exclamation-triangle"></i>
                  <p>A Localização capturada não é totalmente precisa</p>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">Cidade:</label>
                  <span>{!city!}</span>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">CEP:</label>
                  <span>{!zip!}</span>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">País:</label>
                  <span>{!country!}</span>
                </div>
              </div>
              <div style="margin: 25px 0 30px 0;" class="overflow-hidden w100 flex-column  ">
                <h3 style="font-weight:bold" class="txt-shadow">Google Maps:</h3>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">longitude:</label>
                  <span>{!long!}</span>
                </div>
                <div class="row txt-shadow">
                  <label class="main-green" style="font-weight: bold;font-size: 22px">latitude:</label>
                  <span>{!lat!}</span>
                </div>
                <div id="map"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>`
}

export default fragments;