import request from '@/utils/request'

/**
 * 会员管理 - 获取会员列表
 * @param {*} dateRange - 注册日期
 * @param {*} userId - 会员id
 * @param {*} isOnline - 是否在线
 * @param {*} userEmail - 账号id
 * @param {*} mobileNumber - 手机号
 * @param {*} realName - 支付宝姓名
 * @param {*} aliPayAccount - 支付宝账号
 */
export function getList(dateRange, userId, isOnline, userEmail, mobileNumber, realName, aliPayAccount) {
  const data = {
    cmd: 51,
    param: {
      dateRange: dateRange,
      userId: userId,
      isOnline: isOnline,
      userEmail: userEmail,
      mobileNumber: mobileNumber,
      realName: realName,
      aliPayAccount: aliPayAccount
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 获取登陆日志
 * @param {*} dateRange
 * @param {*} userId
 * @param {*} ip
 */
export function getLoginLog(dateRange, userId, ip) {
  const data = {
    cmd: 52,
    param: {
      dateRange: dateRange,
      userId: userId,
      ip: ip
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 获取标签
 * @param {*} searchStr
 * @param {*} gameStatus
 */
export function getLabel() {
  const data = {
    cmd: 53,
    param: {
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 添加标签
 * @param {*} gameName
 * @param {*} gameStatus
 */
export function addLabel() {
  const data = {
    cmd: 54,
    param: {
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 获取等级
 * @param {*} dateRange
 * @param {*} gameId
 * @param {*} roomId
 * @param {*} userId
 */
export function getLv() {
  const data = {
    cmd: 55,
    param: {
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 新增等级
 * @param {*} lvName - 等级名称
 * @param {*} upPrice - 晋升条件
 * @param {*} templateId - 出款稽核模板id
 * @param {*} note - 备注
 */
export function addLv(name, upPrice, templateId, note) {
  const data = {
    cmd: 56,
    param: {
      name: name,
      upPrice: upPrice,
      templateId: templateId,
      note: note
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 编辑等级
 * @param {*} lvName - 等级名称
 * @param {*} upPrice - 晋升条件
 * @param {*} templateId - 出款稽核模板id
 * @param {*} note - 备注
 */
export function editLv(name, upPrice, templateId, note) {
  const data = {
    cmd: 57,
    param: {
      name: name,
      upPrice: upPrice,
      templateId: templateId,
      note: note
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 会员管理 - 删除等级
 * @param {*} lvName - 等级名称
 */
export function delLv(name) {
  const data = {
    cmd: 58,
    param: {
      name: name
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}
