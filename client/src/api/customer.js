import request from '@/utils/request'

/**
 * 用户信息管理 - 获取用户详细信息
 * @param {*} accountId
 * @param {*} userId
 * @param {*} aliPayAccount
 * @param {*} aliPayName
 * @param {*} mac
 * @param {*} ip
 * @param {*} bindPhone
 * @param {*} isRecharge
 */
export function userDetailGet(accountId, userId, aliPayAccount, aliPayName, mac, ip, bindPhone, isRecharge) {
  const data = {
    cmd: 501,
    param: {
      accountId: accountId,
      userId: userId,
      aliPayAccount: aliPayAccount,
      aliPayName: aliPayName,
      mac: mac,
      ip: ip,
      bindPhone: bindPhone,
      isRecharge: isRecharge
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 用户信息管理 - 获取用户详细信息
 */
export function userDetailGetMax() {
  const data = {
    cmd: 502,
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
 * 用户注册列表 - 获取
 * @param {*} dateRange
 */
export function userRegisterListGet(dateRange) {
  const data = {
    cmd: 504,
    param: {
      dateRange: dateRange
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 黑名单信息管理 - 获取
 * @param {*} dateRange
 * @param {*} keyword
 */
export function blacklistGet(dateRange, keyword) {
  const data = {
    cmd: 505,
    param: {
      dateRange: dateRange,
      keyword: keyword
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 黑名单信息管理 - 解封批操作
 * @param {*} dateRange
 * @param {*} keyword
 */
export function blacklistBatchDeBlock() {
  const data = {
    cmd: 506,
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
 * 黑名单信息管理 - 解封单个
 * @param {*} dateRange
 * @param {*} keyword
 */
export function blacklistDeBlock() {
  const data = {
    cmd: 507,
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
 * 黑名单信息管理 - 批量踢出相关用户id
 * @param {*} dateRange
 * @param {*} keyword
 */
export function blacklistBatchBlock(dateRange, keyword) {
  const data = {
    cmd: 508,
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
 * 黑名单信息管理 - 批量封用户id-恶劣密码
 * @param {*} dateRange
 * @param {*} keyword
 */
export function blacklistBatchBlockPass() {
  const data = {
    cmd: 509,
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
 * 玩家金豆变化记录 - 获取
 * @param {*} dateTimeRange
 * @param {*} gameId
 * @param {*} eventId
 * @param {*} userId
 * @param {*} account
 */
export function goldLogGet(dateTimeRange, gameId, eventId, userId, account) {
  const data = {
    cmd: 512,
    param: {
      dateTimeRange: dateTimeRange,
      gameId: gameId,
      eventId: eventId,
      userId: userId,
      account: account
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 玩家金豆变化记录 - 导出excel
 */
export function goldLogExport() {
  const data = {
    cmd: 513,
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
 * 玩家金豆变化(24小时内)
 * @param {*} userId
 */
export function goldLog24Get(userId) {
  const data = {
    cmd: 514,
    param: {
      userId: userId
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 玩家订单查询 - 获取
 */
export function orderInfoGet() {
  const data = {
    cmd: 515,
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
 * 玩家订单查询 - 获取延时订单
 */
export function orderInfoGetDelay() {
  const data = {
    cmd: 516,
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
 * 支付宝转账订单审核 - 获取支付宝转账订单
 * @param {*} userId
 * @param {*} orderId
 * @param {*} aliPayOrderId
 * @param {*} aliPayAccount
 * @param {*} dateTimeRange
 * @param {*} orderStatus
 */
export function aliPayTransferCheckGet(userId, orderId, aliPayOrderId, aliPayAccount, dateTimeRange, orderStatus) {
  const data = {
    cmd: 517,
    param: {
      userId: userId,
      orderId: orderId,
      aliPayOrderId: aliPayOrderId,
      aliPayAccount: aliPayAccount,
      dateTimeRange: dateTimeRange,
      orderStatus: orderStatus
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 支付宝转账订单审核 - 确认转账成功
 */
export function aliPayTransferCheckConfirm() {
  const data = {
    cmd: 518,
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
 * 支付宝转账订单审核 - 修改金额
 * @param {*} orderId
 * @param {*} money
 */
export function aliPayTransferCheckModify(orderId, money) {
  const data = {
    cmd: 519,
    param: {
      orderId: orderId,
      money: money
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 支付宝转账订单审核 - 关闭订单
 * @param {*} orderId
 * @param {*} reason
 */
export function aliPayTransferCheckClose(orderId, reason) {
  const data = {
    cmd: 520,
    param: {
      orderId: orderId,
      reason: reason
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 支付宝转账卡号卡密 - 获取
 * @param {*} aliPayOrderId
 * @param {*} aliPayAccount
 * @param {*} userId
 * @param {*} cardNumber
 * @param {*} cardPassword
 * @param {*} orderStatus
 * @param {*} dateTimeRange
 */
export function aliPayTransferCardGet(aliPayOrderId, aliPayAccount, userId, cardNumber, cardPassword, orderStatus, dateTimeRange) {
  const data = {
    cmd: 521,
    param: {
      aliPayOrderId: aliPayOrderId,
      aliPayAccount: aliPayAccount,
      userId: userId,
      cardNumber: cardNumber,

      cardPassword: cardPassword,
      orderStatus: orderStatus,
      dateTimeRange: dateTimeRange
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}
