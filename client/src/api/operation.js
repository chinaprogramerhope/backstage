import request from '@/utils/request'

/**
 * 运营管理 - 系统利润
 * @param {*} dateRange
 */
export function systemProfitGet(dateRange) {
  const data = {
    cmd: 353,
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
