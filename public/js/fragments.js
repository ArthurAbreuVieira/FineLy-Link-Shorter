const fragments = {
  formOptions:
  `<h3>Alterar dados</h3>
  <div class="h100 w100 flex-start" style="margin: 30px 0 0 70px">
    <div class="flex-collumn row overflow-hidden" style="max-height: 95px;">
      <label class="txt-shadow">Nome:</label>
      <span class="txt-shadow">Arthur Abreu VIeira MendesArthur</span>
      <button data-edit="name" class="btn input txt-shadow gradient"><i class="fas fa-user-edit"></i>
      Editar</button>
    </div>
    <div class="flex-collumn row overflow-hidden " style="max-height: 95px;">
      <label class="txt-shadow">Email:</label>
      <span class="txt-shadow">Arthur Abreu VIeira MendesArthur</span>
      <button data-edit="email" class="btn input txt-shadow gradient"><i class="fas fa-user-edit"></i>Editar</button>
    </div>
    <div class="flex-collumn row overflow-hidden " style="max-height: 95px;">
      <label class="txt-shadow">Senha:</label>
      <span class="txt-shadow">******</span>
      <button data-edit="password" class="btn input txt-shadow gradient"><i class="fas fa-user-edit"></i>Editar</button>
    </div>
  </div>`,
  formUpdate: 
  `<div class="w100 h100 flex-center-collumn">
    <label>{!label!}</label>
    <input data-type="{!data-type!}" class="link-input input radius" type="{!type!}" placeholder="{!placeholder!}" required/>
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
        <div class="flex-collumn">
          <div style="margin-top: 25px;" class="overflow-hidden w50">
            <span style="font-weight:bold" class="txt-shadow">Redirecionamento atual:</span>
            <h3><a href="{{link.redirect}}" class="main-green txt-shadow">{{link.redirect}}</a></h3>
          </div>
          <div style="margin-top: 25px;" class="overflow-hidden w50">
            <span style="font-weight:bold" class="txt-shadow">Código do link:</span>
            <h3><a href="{{link.shorted}}" class="main-green txt-shadow">{{link.id}}</a></h3>
          </div>
        </div>
        <div id="main-content" class="w100 flex-center-collumn" style="margin-top: 30px;">
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
          <div class="flex-collumn">
            <div style="margin-top: 25px;" class="overflow-hidden w50">
              <span style="font-weight:bold" class="txt-shadow">Redirecionamento atual:</span>
              <h3><a href="{{link.redirect}}" class="main-green txt-shadow">{{link.redirect}}</a></h3>
            </div>
            <div style="margin-top: 25px;" class="overflow-hidden w50">
              <span style="font-weight:bold" class="txt-shadow">Código do link:</span>
              <h3><a href="{{link.shorted}}" class="main-green txt-shadow">{{link.id}}</a></h3>
            </div>
            <div style="margin-top: 25px;" class="overflow-hidden w50">
              <span style="font-weight:bold" class="txt-shadow">Total de cliques:</span>
              <h3 class="main-green txt-shadow">{{link.click_count}}</h3>
            </div>
          </div>
          <div id="main-content" class="w100 flex-center-collumn" style="margin-top: 30px;">
            <input id="submit" class="btn input red-gradient txt-shadow radius" type="submit" value="Confirmar exclusão" />
          </div>
        </div>
      </div>
    </div>`
}

export default fragments;