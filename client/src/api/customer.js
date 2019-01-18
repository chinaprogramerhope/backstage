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

