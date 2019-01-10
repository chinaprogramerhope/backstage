import request from '@/utils/request'

/**
 * 运营管理 - 系统利润
 * @param {*} dateRange
 */
export function systemProfitGet() {
  const data = {
    cmd: 353,
    param: {
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}
