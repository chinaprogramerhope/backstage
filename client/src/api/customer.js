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
