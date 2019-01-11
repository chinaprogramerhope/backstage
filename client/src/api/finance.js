import request from '@/utils/request'

/**
 * 财务统计 - 获取
 * @param {*} dateRange
 */
export function finStatisticsGet(dateRange) {
  const data = {
    cmd: 158,
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
 * 财务统计 - 更新昨日充值数据
 */
export function finStatisticsUpdate() {
  const data = {
    cmd: 159,
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
 * 支付统计 - 获取
 * @param {*} dateRange
 * @param {*} channelId
 * @param {*} payType
 */
export function payStatisticsGet(dateRange, channelId, payType) {
  const data = {
    cmd: 160,
    param: {
      dateRange: dateRange,
      channelId: channelId,
      payType: payType
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 提现总额统计 - 获取
 */
export function withdrawalTotalGet() {
  const data = {
    cmd: 161,
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
 * 运营统计 - 获取
 */
export function financeReportGet() {
  const data = {
    cmd: 162,
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
 * 对账统计 - 获取
 */
export function reconciliationReportGet() {
  const data = {
    cmd: 163,
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
 * 代付账号管理 - 获取
 * @param {*} dateRange
 * @param {*} bankcardNo
 * @param {*} bankBranch
 * @param {*} cardholderName
 * @param {*} cardholderMobile
 * @param {*} describe
 */
export function payAccountManageGet(dateRange, bankcardNo, bankBranch, cardholderName, cardholderMobile, describe) {
  const data = {
    cmd: 164,
    param: {
      dateRange: dateRange,
      bankcardNo: bankcardNo,
      bankBranch: bankBranch,
      cardholderName: cardholderName,
      cardholderMobile: cardholderMobile,
      describe: describe
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 代付账号管理 - 创建新账号
 * @param {*} bankcardNo - 收款账号
 * @param {*} bankBranch - 银行名称
 * @param {*} cardholderName - 收款人姓名
 * @param {*} cardholderMobile - 收款人手机
 * @param {*} headquartersBankId - 客户类型
 * @param {*} issueBankId - 资产类型
 * @param {*} describe - 备注
 * @param {*} customerType - 客户类型
 * @param {*} accountType - 资产类型
 */
export function payAccountManageCreate(bankcardNo, bankBranch, cardholderName, cardholderMobile,
  headquartersBankId, issueBankId, describe, customerType,
  accountType) {
  const data = {
    cmd: 165,
    param: {
      bankcardNo: bankcardNo,
      bankBranch: bankBranch,
      cardholderName: cardholderName,
      cardholderMobile: cardholderMobile,

      headquartersBankId: headquartersBankId,
      issueBankId: issueBankId,
      describe: describe,
      customerType: customerType,
      accountType: accountType
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 代付订单管理 - 获取
 * @param {*} dateRange
 * @param {*} cardId
 * @param {*} amount
 * @param {*} outTradeNo
 * @param {*} messageNotify
 * @param {*} orderStatus
 * @param {*} payPlatform
 */
export function payOrderManageGet(dateRange, cardId, amount, outTradeNo, messageNotify, orderStatus, payPlatform) {
  const data = {
    cmd: 166,
    param: {
      dateRange: dateRange,
      cardId: cardId,
      amount: amount,
      outTradeNo: outTradeNo,
      messageNotify: messageNotify,
      orderStatus: orderStatus,
      payPlatform: payPlatform
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 代付订单管理 - 更新派支付提款单状态
 */
export function payOrderManageUpdate() {
  const data = {
    cmd: 167,
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
 * 代付订单管理 - 提现
 */
export function payAccountManageCashWithdrawal() {
  const data = {
    cmd: 168,
    param: {
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

