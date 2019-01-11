import request from '@/utils/request'

/**
 * 推广账号 - 获取
 */
export function promotionAccountGet() {
  const data = {
    cmd: 260,
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
 * 推广账号 - 添加
 */
export function promotionAccountAdd() {
  const data = {
    cmd: 261,
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
 * 推广账号 - 修改
 */
export function promotionAccountEdit() {
  const data = {
    cmd: 262,
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
 * 推广账号 - 获取操作日志
 */
export function promotionAccountOperationLogGet() {
  const data = {
    cmd: 263,
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
 * 推广账号 - 获取收入统计
 */
export function promotionAccountIncomeGet() {
  const data = {
    cmd: 264,
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
 * 推广信用金日志 - 获取
 */
export function promotionBalanceLogGet() {
  const data = {
    cmd: 265,
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
 * 推广统计 - 获取
 */
export function promotionStatisticsGet() {
  const data = {
    cmd: 266,
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
 * 推广统计 - 统计
 */
export function promotionStatisticsOneGet() {
  const data = {
    cmd: 267,
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
 * 推广统计 - 查询
 */
export function promotionStatisticsOneQuery() {
  const data = {
    cmd: 268,
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
 * 推广ID修正 - 获取用户的推广id
 */
export function promotionCorrectionGetId() {
  const data = {
    cmd: 269,
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
 * 推广ID修正 - 修正用户的推广id
 */
export function promotionCorrectionUpdate() {
  const data = {
    cmd: 270,
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
 * 推广ID修正 - 获取修正日志
 */
export function promotionCorrectionGetLog() {
  const data = {
    cmd: 271,
    param: {
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}
