import request from '@/utils/request'

/**
 * 财务统计 - 获取
 */
export function finStatisticsGet() {
  const data = {
    cmd: 158,
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
 */
export function payStatisticsGet() {
  const data = {
    cmd: 160,
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
 */
export function payAccountManageGet() {
  const data = {
    cmd: 164,
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
 * 代付账号管理 - 创建新账号
 */
export function payAccountManageCreate() {
  const data = {
    cmd: 165,
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
 * 代付订单管理 - 获取
 */
export function payOrderManageGet() {
  const data = {
    cmd: 166,
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
